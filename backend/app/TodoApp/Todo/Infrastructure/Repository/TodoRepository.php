<?php

namespace App\TodoApp\Todo\Infrastructure\Repository;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;
use App\TodoApp\Todo\Domain\Todo;
use App\TodoApp\Todo\Domain\TodoCreateForm;
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

        if (is_null($category)) {
            $results = self::get();
        } else {
            $results = self::where('category_id', $category->getId())->get();
        }

        if (is_null($results)) {
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
}
