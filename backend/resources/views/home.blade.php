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
                    <form>
                        <div class="card" style="width:70%;margin:auto;">
                            <div class="card-body" style="padding-bottom: 3px">
                                <textarea class="form-control" placeholder="タイトルを入力" rows="1" style="resize:none;margin:3px"></textarea>
                                <textarea class="form-control" placeholder="内容を入力" rows="2" style="resize:none;margin:3px"></textarea>
                                <div class="form-row" style="padding-top: 10px">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="category">カテゴリ</label>
                                        <select id="category" class="form-control">
                                            <option selected></option>
                                            @foreach ($datas["category_dto_list"]->getList() as $category)
                                                <option> {{$category->getName()}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="scale">規模</label>
                                        <select id="category" class="form-control">
                                            <option selected></option>
                                            @foreach ($datas["scale_list"] as $scale)
                                                <option> {{$scale}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="deadline">期日</label>
                                        <input type="text" id="datepicker" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-secondary float-right">登録</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>

                <div class="row">
                    @foreach ($datas["todo_dto_list"]->getList() as $todo)
                        <div class="card col-sm-3 todo-card">
                            <div class="card-header">
                                <h3 class="card-title"><strong>{{$todo->getTitle()}}</strong></h3>
                                <div class="card-tools">
                                    <!-- Buttons, labels, and many other things can be placed here! -->
                                    <!-- Here is a label for example -->
                                    <span class="badge badge-primary">{{$todo->getOrigin()}}</span>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                {{$todo->getDescription()}}
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{$todo->getDeadLine()}}
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    @endforeach
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
</style>

<script>
    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'yy/mm/dd'
        });
    })
</script>

@endsection
