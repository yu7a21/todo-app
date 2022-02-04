<!DOCTYPE html>

@foreach ($datas["todo_dto_list"]->getList() as $todo)
    title:{{$todo->getTitle()}}
    description:{{$todo->getDescription()}}
@endforeach
