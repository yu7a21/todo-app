@extends('layouts')

@section('title', $title)

@section('content')
<body>
    <div class="wrapper">
        @include('header')
        @include('sidebar')
        <div class="content-wrapper">
            <div class="content">
            {{-- TODO: フォームをモーダルにして、既存のタスクをクリックされたときに同じフォームを使って編集画面を出す --}}
            {{-- タスク新規作成フォーム --}}
            <div class="modal fade" id="todoCreateModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="{{route('create')}}" id="todoCreateForm">
                            @csrf
                            <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                            <div class="modal-header">
                                {{-- <h4 class="modal-title">タスクフォーム</h4> --}}
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="create-todo-form-container">
                                <textarea class="form-control" id="modalTitle" name="title" placeholder="タイトルを入力" rows="1" style="resize:none;margin:3px"></textarea>
                                <textarea class="form-control" id="modalDescription" name="description" placeholder="内容を入力" rows="2" style="resize:none;margin:3px"></textarea>
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
                                        <input type="text" id="deadline" class="form-control" name="deadline">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary float-right">登録</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            {{-- タスク編集フォーム --}}
            <div class="modal fade" id="todoEditModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="{{route('update')}}" id="todoEditForm">
                            @csrf
                            <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="editModalId" name="id">
                            <div class="modal-header">
                                {{-- <h4 class="modal-title">タスクフォーム</h4> --}}
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="create-todo-form-container">
                                <textarea class="form-control" id="editModalTitle" name="title" placeholder="タイトルを入力" rows="1" style="resize:none;margin:3px"></textarea>
                                <textarea class="form-control" id="editModalDescription" name="description" placeholder="内容を入力" rows="2" style="resize:none;margin:3px"></textarea>
                                <div class="form-row" style="padding-top: 10px">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="editModalCategory">カテゴリ</label>
                                        <select id="editModalCategory" class="form-control" name="category_id">
                                            <option selected></option>
                                            @foreach ($datas["category_dto_list"]->getList() as $category)
                                                <option value="{{$category->getId()}}"> {{$category->getName()}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="scale">規模</label>
                                        <select id="editModalScale" class="form-control" name="scale">
                                            <option selected></option>
                                            @foreach ($datas["scale_list"] as $scale => $scale_ja)
                                                <option value="{{$scale}}"> {{$scale_ja}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="editModalDeadline">期日</label>
                                        <input type="text" id="editModalDeadline" class="form-control" name="deadline">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary float-right">更新</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <div style="text-align: center">
                <button href="#" class="btn btn-secondary" data-toggle="modal" data-target="#todoCreateModal" style="margin:20px 0;">タスク追加</button>
            </div>
            <div class="todo-list-container container">
                <div class="card-columns">
                    @foreach ($datas["todo_dto_list"]->getList() as $todo)
                    {{-- おわったタスクページ、やめたタスクページでは色を変えない&編集モーダルを出さない --}}
                        @if($title != "おわったタスク" && $title != "やめたタスク")
                            <div class="card todo-card" data-id="{{$todo->getId()}}" style="border-radius: 10px;background-color:{{$todo->getColorCode()}}">
                            <input type="hidden" id="todoScale_{{$todo->getId()}}" value="{{$todo->getScale()->getScale()}}">
                        @else
                            <div class="card todo-card" style="border-radius: 10px;">
                        @endif
                        <div class="card-header">
                                <h3 class="card-title" id="todoTitle_{{$todo->getId()}}" onclick="showEditModal({{$todo->getId()}})"><strong>{{$todo->getTitle()}}</strong></h3>
                                <div class="card-tools">
                                    {{-- インポートされたタスクは元チケットへのリンクを入れる --}}
                                    @if ($todo->getOrigin()->getOrigin() == "backlog")
                                        <span class="badge badge-success" id="modal-ignore">
                                            <a style="color:white;text-decoration:underline;" target="_blank" href={{$todo->getTicketLink()}}>{{$todo->getOrigin()->getOrigin()}}</a>
                                        </span>
                                    @elseif ($todo->getOrigin()->getOrigin() == "redmine")
                                        <span class="badge badge-danger" id="modal-ignore">
                                            <a style="color:white;text-decoration:underline;" target="_blank" href={{$todo->getTicketLink()}}>{{$todo->getOrigin()->getOrigin()}}</a>
                                        </span>
                                    @else
                                        <span class="badge badge-info">{{$todo->getOrigin()->getOrigin()}}</span>
                                    @endif
                                    {{-- カテゴリが設定されているタスクはカテゴリ別ページへのリンクを入れる --}}
                                    @if ($todo->getCategoryId() != "")
                                        <?php $category_name = $datas["category_dto_list"]->getById($todo->getCategoryId())->getName()?>
                                        <input type="hidden" id="todoCategoryId_{{$todo->getId()}}" value="{{ $todo->getCategoryId() }}">
                                        <span class="badge badge-secondary" id="modal-ignore">
                                            <a style="color:white;text-decoration:underline;" href={{ route("category", ["category_name" => $category_name])}}>#{{$category_name}}</a>
                                        </span>
                                    @endif
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="height:auto" onclick="showEditModal({{$todo->getId()}})">
                                <p id="todoDescription_{{$todo->getId()}}">{{$todo->getDescription()}}</p>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="container">
                                    <div class="row">
                                        {{-- 期日があるもののみ表示 --}}
                                        @if($todo->getDeadLine() != "")
                                            <div class="col-sm-8"style="text-align: left" onclick="showEditModal({{$todo->getId()}})">
                                                {{-- 期日を過ぎていたら赤くする。おわったタスクページ、やめたタスクページでは赤くしない --}}
                                                @if($todo->isOutOfDeadline() && $title != "おわったタスク" && $title != "やめたタスク")
                                                    <p style="color:red; margin:0;" id="todoDeadline_{{$todo->getId()}}"><i class="fas fa-calendar-times"></i> : {{$todo->getDeadLine()}}</p>
                                                @else
                                                    <p style="margin:0;"  id="todoDeadline_{{$todo->getId()}}"><i class="fas fa-calendar-times"></i> : {{$todo->getDeadLine()}}</p>
                                                @endif
                                            </div>
                                        @else
                                            <div class="col-sm-8" style="text-align: left">
                                            </div>
                                        @endif
                                        {{-- おわったタスクページ、やめたタスクページでは表示しない --}}
                                        @if ($title != "おわったタスク" && $title != "やめたタスク")
                                            <div class="col-sm-2" style="text-align: center;">
                                                <form method="POST" id="complete_form_{{$todo->getId()}}" action="{{ route('complete_todo')}}">
                                                    @csrf
                                                    <input type="hidden" name="id" value={{$todo->getId()}}>
                                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                                    <a id="modal-ignore" href="javascript:complete_form_{{$todo->getId()}}.submit()" class="nav-link" style="display:inline;padding:3px;color:black"><i class="nav-icon far fa-check-circle"></i></a>
                                                </form>
                                            </div>
                                            <div class="col-sm-2" style="text-align: center;">
                                                <form method="POST" id="delete_form_{{$todo->getId()}}" action="{{ route('delete_todo')}}">
                                                    @csrf
                                                    <input type="hidden" name="id" value={{$todo->getId()}}>
                                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                                    <a id="modal-ignore" href="javascript:delete_form_{{$todo->getId()}}.submit()" class="nav-link" style="display:inline;padding:3px;color:black"><i class="nav-icon fas fa-trash-alt"></i></a>
                                                </form>
                                            </div>
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
        $('#deadline').datepicker({
            dateFormat: 'yy/mm/dd'
        });

        $('#editModalDeadline').datepicker({
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

        $('#todoEditForm').validate({
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

    function showEditModal(todo_id) {
            //クリックされたタスクの情報（タイトル、内容など）を取得
            var title = $('#todoTitle_'+todo_id).text();
            var description = $('#todoDescription_'+todo_id).text();
            var category_id = $('#todoCategoryId_'+todo_id).val();
            var scale = $('#todoScale_'+todo_id).val();
            var deadline = $('#todoDeadline_'+todo_id).text().slice(3); //コロンとスペースが入っているのでその分の前三文字を削除

            //モーダルの各要素に取得した情報をいれる
            $('#editModalId').val(todo_id);
            $('#editModalTitle').val(title);
            $('#editModalDescription').val(description);
            $("#editModalCategory option[value='"+category_id+"']").prop('selected', true);
            $('#editModalScale').val(scale);
            $('#editModalDeadline').val(deadline);

            $('#todoEditModal').modal();
        }

</script>

@endsection
