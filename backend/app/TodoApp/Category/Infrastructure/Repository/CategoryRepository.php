<?php

namespace App\TodoApp\Category\Infrastructure\Repository;

use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Category\Domain\CategoryForm;
use App\TodoApp\Category\Infrastructure\Interface\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends Model implements CategoryRepositoryInterface
{
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    /**
     * カテゴリ名からカテゴリを取得
     * category_nameが空だった場合nullを返す
     *
     * @param  mixed $category_name
     * @return Category
     */
    public function findByName(string $category_name): ?Category
    {
        $result = self::where('name', $category_name)->first();

        if (is_null($result)) {
            return null;
        } else {
            return new Category($result->toArray());
        }
    }

    /**
     * 全カテゴリ取得
     *
     * @return Category[]
     */
    public function findAll(): array
    {
        $category_array = [];
        foreach (self::get()->toArray() as $result) {
            $category_array[] = new Category($result);
        }
        return $category_array;
    }

    /**
     * カテゴリ作成
     *
     * @param  CategoryForm $category_form
     * @return void
     */
    public function create(CategoryForm $category_form): void
    {
        $category_repository = new CategoryRepository([
            'name' => $category_form->getName()
        ]);
        $category_repository->save();
    }

    /**
     * カテゴリ更新
     *
     * @param  CategoryForm $category_form
     * @return void
     */
    public function updateCategory(CategoryForm $category_form): void
    {
        self::where('id', $category_form->getId())->update(["name" => $category_form->getName()]);
    }

    /**
     * カテゴリを削除する
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        self::where('id', $id)->delete();
    }

}
