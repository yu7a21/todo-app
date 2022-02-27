@extends('layouts')

@section('title', $title)

@section('content')
<body>
    <div class="wrapper">
        @include('header')
        @include('sidebar')
        <div class="content-wrapper">
            <div class="content">

                {{-- タスク新規作成フォーム --}}
                <div class="create-todo-form-container">
                    <form method="POST" action="{{route('create')}}" id="todoCreateForm">
                        @csrf
                        <div class="card" style="width:70%;margin:auto;">
                            <div class="card-body" style="padding-bottom: 3px">
                                <textarea class="form-control" name="title" placeholder="タイトルを入力" rows="1" style="resize:none;margin:3px"></textarea>
                                <textarea class="form-control" name="description" placeholder="内容を入力" rows="2" style="resize:none;margin:3px"></textarea>
                                <div class="form-row" style="padding-top: 10px">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="category">カテゴリ</label>
                                        <select id="category" class="form-control" name="category_id">
                                            <option selected></option>
                                            @foreach ($datas["category_dto_list"]->getList() as $category)
                                                <option value="{{$category->getId()}}"> {{$category->getName()}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="scale">規模</label>
                                        <select id="scale" class="form-control" name="scale">
                                            <option selected></option>
                                            @foreach ($datas["scale_list"] as $scale => $scale_ja)
                                                <option value="{{$scale}}"> {{$scale_ja}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="deadline">期日</label>
                                        <input type="text" id="datepicker" class="form-control" name="deadline">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-secondary float-right" value="{{ csrf_token() }}">登録</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>
                <div class="todo-list-container container">
                    <div class="card-columns">
                        @foreach ($datas["todo_dto_list"]->getList() as $todo)
                        {{-- おわったタスクページ、やめたタスクページでは色を変えない --}}
                            @if($title != "おわったタスク" && $title != "やめたタスク")
                                <div class="card todo-card" style="border-radius: 10px;background-color:{{$todo->getColorCode()}}">
                            @else
                                <div class="card todo-card" style="border-radius: 10px;">
                            @endif
                            <div class="card-header">
                                    <h3 class="card-title"><strong>{{$todo->getTitle()}}</strong></h3>
                                    <div class="card-tools">
                                        @if ($todo->getOrigin()->getOrigin() == "backlog")
                                            <span class="badge badge-success">
                                                <a style="color:white;text-decoration:underline;" target="_blank" href={{$todo->getTicketLink()}}>{{$todo->getOrigin()->getOrigin()}}</a>
                                            </span>
                                        @elseif ($todo->getOrigin()->getOrigin() == "redmine")
                                            <span class="badge badge-danger">
                                                <a style="color:white;text-decoration:underline;" target="_blank" href={{$todo->getTicketLink()}}>{{$todo->getOrigin()->getOrigin()}}</a>
                                            </span>
                                        @else
                                            <span class="badge badge-info">{{$todo->getOrigin()->getOrigin()}}</span>
                                        @endif
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="height:auto">
                                    {{$todo->getDescription()}}
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <div class="container">
                                        <div class="row">
                                            {{-- 期日があるもののみ表示 --}}
                                            @if($todo->getDeadLine() != "")
                                                <div class="col-sm-8" style="text-align: left">
                                                    {{-- 期日を過ぎていたら赤くする。おわったタスクページ、やめたタスクページでは赤くしない --}}
                                                    @if($todo->isOutOfDeadline() && $title != "おわったタスク" && $title != "やめたタスク")
                                                        <p style="color:red; margin:0;"><i class="fas fa-calendar-times"></i> : {{$todo->getDeadLine()}}</p>
                                                    @else
                                                        <p style="margin:0;"><i class="fas fa-calendar-times"></i> : {{$todo->getDeadLine()}}</p>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="col-sm-8" style="text-align: left">
                                                </div>
                                            @endif
                                            {{-- おわったタスクページ、やめたタスクページでは表示しない --}}
                                            @if ($title != "おわったタスク" && $title != "やめたタスク")
                                                <form method="POST" id="complete_form_{{$todo->getId()}}" action="{{ route('complete_todo')}}">
                                                    @csrf
                                                    <input type="hidden" name="id" value={{$todo->getId()}}>
                                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                                    <div class="col-sm-2" style="text-align: center;">
                                                        <a href="javascript:complete_form_{{$todo->getId()}}.submit()" class="nav-link" style="display:inline;padding:3px;color:black"><i class="nav-icon far fa-check-circle"></i></a>
                                                    </div>
                                                </form>
                                                <form method="POST" id="delete_form_{{$todo->getId()}}" action="{{ route('delete_todo')}}">
                                                    @csrf
                                                    <div class="col-sm-2" style="text-align: center;">
                                                        <input type="hidden" name="id" value={{$todo->getId()}}>
                                                        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                                        <a href="javascript:delete_form_{{$todo->getId()}}.submit()" class="nav-link" style="display:inline;padding:3px;color:black"><i class="nav-icon fas fa-trash-alt"></i></a>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- jQuery -->
<script src="/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
<!-- jQuery-UI -->
<script src="/AdminLTE-3.1.0/plugins/jquery-ui/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/AdminLTE-3.1.0/plugins/jquery-ui-1.12.1.vader/jquery-ui.min.css">
<!-- jQuery -->
<script src="/AdminLTE-3.1.0/plugins/jquery-validation/jquery.validate.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE-3.1.0/dist/js/adminlte.min.js"></script>

<style>
.create-todo-form-container{
    padding:20px;
}

.todo-card{
    margin: 5px;
}

form.cmxform label.error, label.error {
    color: red;
    padding-left:20px;
    padding-top:5px;
}
</style>

<script>
    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'yy/mm/dd'
        });

        // バリデーション
        $('#todoCreateForm').validate({
            rules: {
                title: {
                    required: true
                },
            },
            messages: {
                title: {
                    required: "タイトルを入力してください"
                }
            },
        });
    })

</script>

@endsection
