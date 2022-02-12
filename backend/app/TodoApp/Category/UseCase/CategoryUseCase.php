<?php

namespace App\TodoApp\Category\UseCase;

use App\TodoApp\Category\Infrastructure\Interface\CategoryRepositoryInterface;
use App\TodoApp\Category\Domain\Category;
use App\TodoApp\Category\Domain\CategoryDTO;
use App\TodoApp\Category\Domain\CategoryDTOList;

class CategoryUseCase
{
    public function __construct()
    {
        $this->category_repository = app()->make(CategoryRepositoryInterface::class);
    }

    public function findAll(): CategoryDTOList
    {
        $category_array = $this->category_repository->findAll();
        $category_dto = [];
        foreach ($category_array as  $category) {
            $category_dto[] = new CategoryDTO($category);
        }

        return new CategoryDTOList($category_dto);
    }

    public function findByName(string $category_name = ""): ?Category
    {
        return $this->category_repository->findByName($category_name);
    }

    /**
     * カテゴリ名がDBに存在するかをチェック
     *
     * @param  mixed $category_name
     * @param  mixed $category_dto_list
     * @return bool
     */
    public function existCategoryName(string $category_name): bool
    {
        $category_dto_list = $this->findAll();

        if ($category_name != "") {
            foreach ($category_dto_list->getList() as $category_dto) {
                if ($category_dto->getName() === $category_name) {
                    return true;
                }
            }
        } else {
            return true;
        }

        return false;
    }

    public function update(array $category_form_array): void
    {
        //TODO:リポジトリにはformではなくエンティティに詰め替えて渡した方がいいと思います。
        foreach ($category_form_array as $category_form) {
            //IDがないものは新規データ
            if ($category_form->hasNotId()) {
                //カテゴリ名もなかったらスキップ
                if ($category_form->hasNotName()) {
                    continue;
                } else {
                    $this->category_repository->create($category_form);
                }
            } else {
                $this->category_repository->updateCategory($category_form);
            }
        }
    }
}
