<?php

namespace App\TodoApp\Todo\UseCase;

use App\TodoApp\Category\UseCase\CategoryUseCase;
use App\TodoApp\Exception\CategoryNotFoundException;
use App\TodoApp\Todo\Domain\Todo;
use App\TodoApp\Todo\Domain\TodoCreateForm;
use App\TodoApp\Todo\Domain\TodoDTO;
use App\TodoApp\Todo\Domain\TodoDTOList;
use App\TodoApp\Todo\Domain\TodoList;
use App\TodoApp\Todo\Domain\TodoScale;
use App\TodoApp\Todo\Infrastructure\Interface\TodoRepositoryInterface;

use DateTime;

class TodoUseCase
{
    private TodoRepositoryInterface $todo_repository;

    public function __construct()
    {
        $this->todo_repository = app()->make(TodoRepositoryInterface::class);
        $this->category_use_case = new CategoryUseCase();
    }

    public function home(string $category_name = ""): array
    {
        if (!$this->category_use_case->existCategoryName($category_name)) {
            throw new CategoryNotFoundException();
        }

        //全カテゴリ取得
        $category_dto_list = $this->category_use_case->findAll();

        //カテゴリ名からタスク一覧を取得
        $todo_dto_list = $this->findTodoListByCategoryName($category_name);

        return [
            "todo_dto_list" => $todo_dto_list,
            "category_dto_list" => $category_dto_list,
            "scale_list" => TodoScale::getAllValue(),
            "complete_task_count" => $this->countCompletedTodoInThisWeek()
        ];
    }

    public function create(TodoCreateForm $todo_create_form): void
    {
        $this->todo_repository->create($todo_create_form);
    }

    public function delete(int $id): void
    {
        $this->todo_repository->deleteById($id);
    }

    public function complete(int $id): void
    {
        $this->todo_repository->completeById($id);
    }

    public function deletedTodo(): array
    {
        $todo_list = $this->todo_repository->getDeletedTodo();

        if (is_null($todo_list)) {
            $todo_dto_list = new TodoDTOList([]);
        } else {
            $todo_dto_list = $this->convertEntityListToDtoList($todo_list);
        }
        return [
            "todo_dto_list" => $todo_dto_list,
            "category_dto_list" => $this->category_use_case->findAll(),
            "scale_list" => TodoScale::getAllValue(),
            "complete_task_count" => $this->countCompletedTodoInThisWeek()
        ];
    }

    public function completedTodo(): array
    {
        $todo_list = $this->todo_repository->getCompletedTodo();

        if (is_null($todo_list)) {
            $todo_dto_list = new TodoDTOList([]);
        } else {
            $todo_dto_list = $this->convertEntityListToDtoList($todo_list);
        }
        return [
            "todo_dto_list" => $todo_dto_list,
            "category_dto_list" => $this->category_use_case->findAll(),
            "scale_list" => TodoScale::getAllValue(),
            "complete_task_count" => $this->countCompletedTodoInThisWeek()
        ];
    }

    private function countCompletedTodoInThisWeek(): int
    {
        $todo_list = $this->todo_repository->getCompletedTodo($this->getWeekDays());
        if (is_null($todo_list)) {
            return 0;
        } else {
            return $todo_list->count();
        }
    }

    private function getWeekDays() {
        $now = new DateTime();
        $now = $now->format('Y-m-d');
        //PHPのデフォルトは日(0)~土(6)なので月(0)~日(6)にする（月曜始まりにする）
        $w = (date("w",strtotime($now)) == 0) ? 6 : date("w",strtotime($now))-1;

        $beginning_week_date = date('Y-m-d 00:00:00', strtotime("-{$w} day", strtotime($now)));
        return [
            $beginning_week_date,
            date("Y-m-d 23:59:59", strtotime("+6 day", strtotime($beginning_week_date)))
        ];
    }

    private function findTodoListByCategoryName(string $category_name = ""): TodoDTOList
    {
        //カテゴリ名からカテゴリentity取得
        $category = $this->category_use_case->findByName($category_name);

        //カテゴリからタスクデータ取得
        $todo_list = $this->todo_repository->getByCategory($category);

        if (is_null($todo_list)) {
            $todo_dto_list = new TodoDTOList([]);
        } else {
            $todo_dto_list = $this->convertEntityListToDtoList($todo_list);
        }

        //DTOのリストを返す
        return $todo_dto_list;
    }

    private function convertEntityListToDtoList(TodoList $todo_list): TodoDTOList
    {
        $todo_dto_array = [];
        foreach ($todo_list->toArray() as $todo) {
            $todo_dto_array[] = new TodoDTO($todo);
        }

        return new TodoDTOList($todo_dto_array);
    }
}
