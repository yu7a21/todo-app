<?php

namespace App\TodoApp\Todo\Infrastructure\Repository;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;
use App\TodoApp\Todo\Domain\Todo;
use App\TodoApp\Todo\Domain\TodoCreateForm;
use App\TodoApp\Todo\Domain\TodoStatus;
use DateTime;
use Illuminate\Database\Eloquent\Model;

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
     * 完了済みのタスクを取得
     *
     * @return TodoList
     */
    public function getCompletedTodo(): ?TodoList
    {
        $results = self::where("status", TodoStatus::DONE)->get();

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


}
