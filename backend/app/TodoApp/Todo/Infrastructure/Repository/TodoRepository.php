<?php

namespace App\TodoApp\Todo\Infrastructure\Repository;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;
use App\TodoApp\Todo\Domain\Todo;
use App\TodoApp\Todo\Domain\TodoOrigin;
use App\TodoApp\Todo\Domain\TodoCreateForm;
use App\TodoApp\Todo\Domain\TodoScale;
use App\TodoApp\Todo\Domain\TodoStatus;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

use Itigoppo\BacklogApi\Backlog\Backlog;
use Itigoppo\BacklogApi\Connector\ApiKeyConnector;

class TodoRepository extends Model implements TodoRepositoryInterface
{
    protected $table = 'todos';

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'origin',
        'ticket_id',
        'category_id',
        'scale',
        'status',
    ];

    const DESCRIPTION_LENGTH = 300;

    /**
     * カテゴリでタスクを絞り込んで取得
     * nullを渡した場合or引数を渡さなかった場合全件取得する
     *
     * @param  mixed $category
     * @return TodoList
     */
    public function getByCategory(?Category $category = null): ?TodoList
    {

        $query = self::where("is_deleted", false)->where("completed_at", null);

        // カテゴリによる絞り込みがない場合全件取得
        if (!is_null($category)) {
            $results = $query->where('category_id', $category->getId());
        }

        $results = $query->get();

        if (count($results) == 0) {
            return null;
        } else {
            $todo_array = [];
            foreach($results as $result) {
                $todo_array[] = new Todo($result->toArray());
            }
            return new TodoList($todo_array);
        }
    }

    /**
     * ドメインを永続化
     *
     * @param  TodoCreateForm $todo
     * @return void
     */
    public function create(TodoCreateForm $todo_form): void
    {
        //キモすぎ、、、、、、、
        $todo_repository = new TodoRepository([
            'title' => $todo_form->getTitle(),
            'description' => $todo_form->getDescription(),
            'deadline' => $todo_form->getDeadLine() ? $todo_form->getDeadLine() : null,
            'origin' => $todo_form->getOrigin(),
            'ticket_id' => $todo_form->getTicketId(),
            'category_id' => $todo_form->getCategoryId(),
            'scale' => $todo_form->getScale()->getScale(),
            'status' => $todo_form->getStatus()->getStatus(),
        ]);
        $todo_repository->save();
    }

    /**
     * タスクを削除（論理削除）
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        self::where('id', $id)->update(["is_deleted" => true]);
    }

    /**
     * タスクを完了にする（論理削除）
     *
     * @param  mixed $id
     * @return void
     */
    public function completeById(int $id): void
    {
        $now = new DateTime();
        self::where('id', $id)->update(["completed_at" => $now->format('Y-m-d H:i:s'), "status" => TodoStatus::DONE]);
    }

    /**
     * 削除されたタスクを取得
     *
     * @return TodoList
     */
    public function getDeletedTodo(): ?TodoList
    {
        $results = self::where("is_deleted", true)->get();

        if (count($results) == 0) {
            return null;
        } else {
            $todo_array = [];
            foreach($results as $result) {
                $todo_array[] = new Todo($result->toArray());
            }
            return new TodoList($todo_array);
        }
    }

    /**
     * 完了したタスクを取得
     * 引数に配列を渡した場合その範囲の日付で完了になったタスクを検索する
     *
     * @param  mixed $range
     * @return TodoList
     */
    public function getCompletedTodo(array $range = []): ?TodoList
    {
        $query = self::where("status", TodoStatus::DONE);
        //範囲が指定されていたらその範囲で取得
        if (!empty($range) && count($range)) {
            $query->whereBetween('completed_at', $range);
        }

        $results = $query->get();

        if (count($results) == 0) {
            return null;
        } else {
            $todo_array = [];
            foreach($results as $result) {
                $todo_array[] = new Todo($result->toArray());
            }
            return new TodoList($todo_array);
        }
    }

    /**
     * 渡されたカテゴリIDを持つタスクデータのカテゴリIDを削除
     *
     * @param  mixed $category_id
     * @return void
     */
    public function deleteCategoryId(int $category_id): void
    {
        $todos = self::where('category_id', $category_id)->update(["category_id" => ""]);
    }

    /**
     * Redmineからチケットをインポート
     *
     * @return void
     */
    public function importFromRedmine(): void
    {
        $this->client = new Client([
            'base_uri' => "https://mori-building-redmine.team-lab.dev/"
        ]);

        $response = $this->client->request('GET', "/issues.json", [
            'headers' => [],
            'query' => ['key' => env('REDMINE_API_KEY'), 'project_id' => 'hills-app', 'assigned_to_id' => '88', 'limit' => 100]
        ]);

        $issue_list = json_decode($response->getBody()->getContents());
        foreach ($issue_list->issues as $issue) {
            if ($this->isNewIssue($issue->id)) {
                $scale = $this->getScaleByEstimatedHours($issue->estimated_hours);
                $deadline = new Datetime($issue->due_date);

                //キモすぎ、、、、、、、
                $todo_repository = new TodoRepository([
                    'title' => $issue->subject,
                    'description' => mb_substr($issue->description, 0, self::DESCRIPTION_LENGTH),
                    // 'description' => $issue->description,
                    'deadline' => $deadline->format('Y-m-d H:m:s'),
                    'origin' => TodoOrigin::REDMINE,
                    'ticket_id' => $issue->id,
                    'category_id' => "",
                    'scale' => $scale,
                    //redmineはステータスが変わるのでとりあえず全部newで取り込む
                    'status' => TodoStatus::NEW
                ]);
                // dd($todo_repository);
                $todo_repository->save();
            }
        }
    }

    /**
     * Backlogからチケットをインポート
     *
     * @return void
     */
    public function importFromBacklog(): void
    {
        $backlog = new Backlog(new ApiKeyConnector('team-lab', env('BACKLOG_API_KEY'), 'com'));
        $issue_list = $backlog->issues->load([
            'projectId[]'=>env('BACKLOG_PROJECT_ID'),
            'statusId' => [1, 2, 3],
            'assigneeId[]' => env('BACKLOG_ASSIGNEE_ID')
        ]);

        foreach ($issue_list as $issue) {
            if ($this->isNewIssue($issue->issueKey)) {
                $scale = $this->getScaleByEstimatedHours($issue->estimatedHours);

                if ($issue->status->id == 1) {
                    $status = TodoStatus::NEW;
                } else if ($issue->status->id == 2) {
                    $status = TodoStatus::IN_PROGRESS;
                } else {
                    $status = TodoStatus::DONE;
                }

                $deadline = new Datetime($issue->dueDate);
                //キモすぎ、、、、、、、
                $todo_repository = new TodoRepository([
                    'title' => $issue->summary,
                    'description' => mb_substr($issue->description, 0, self::DESCRIPTION_LENGTH),
                    'deadline' => $deadline->format('Y-m-d H:m:s'),
                    'origin' => TodoOrigin::BACKLOG,
                    'ticket_id' => $issue->issueKey,
                    'category_id' => "",
                    'scale' => $scale,
                    'status' => $status
                ]);
                $todo_repository->save();
            }
        }
    }

    private function isNewIssue(string $ticket_id): bool
    {
        return count(self::where("ticket_id", $ticket_id)->get()) == 0;
    }

    private function getScaleByEstimatedHours(?string $estimated_hours): string
    {
        //TODO: このあたりの判定基準は微妙、そもそもここに持たせるべきロジックなのかわからん
        if ($estimated_hours < 8) {
            return TodoScale::SMALL;
        } else if ($estimated_hours < 24) {
            return TodoScale::MIDIUM;
        } else {
            return TodoScale::LARGE;
        }
    }
}
