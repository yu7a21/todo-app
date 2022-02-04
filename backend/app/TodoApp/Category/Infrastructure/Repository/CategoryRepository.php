<?php

namespace App\TodoApp\Category\Infrastructure\Repository;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Category\Infrastructure\Interface\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends Model implements CategoryRepositoryInterface
{
    protected $table = 'categories';

    /**
     * カテゴリ名からカテゴリを取得
     * category_nameが空だった場合nullを返す
     *
     * @param  mixed $category_name
     * @return Category
     */
    public function getByName(string $category_name): ?Category
    {
        $result = self::where('name', $category_name)->first();

        if (is_null($result)) {
            return null;
        } else {
            return new Category($result->toArray());
        }
    }
}
