<?php

namespace App\TodoApp\Todo\Infrastructure\Repository;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;
use App\TodoApp\Todo\Domain\Todo;
use Illuminate\Database\Eloquent\Model;

class TodoRepository extends Model implements TodoRepositoryInterface
{
    protected $table = 'todos';

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
}
