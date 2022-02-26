{{-- カテゴリ編集モーダル --}}
<div class="modal fade" id="categoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">カテゴリ編集</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form method="POST" action="{{route('category_edit')}}" id="categoryForm">
                @csrf
                <div class="modal-body">
                    <div class="container" id="category_form_container">
                        <div class="row" id="category_new">
                            <div class="col-sm-1 d-flex justify-content-center align-items-center"></div>
                            <div class="col-sm-11 d-flex justify-content-center align-items-center">
                                <textarea class="form-control" rows="1" name="category_new" type="text" style="resize:none;width:80%;margin:3px 0" placeholder="新しいカテゴリ名"></textarea>
                            </div>
                        </div>
                        @foreach ($datas["category_dto_list"]->getList() as $category)
                            <div class="row" id="category_{{$category->getId()}}">
                                <div class="col-sm-1 d-flex justify-content-center align-items-center">
                                    <a href="javascript:appendToDeleteCategoryList({{$category->getId()}})" style="color: black"><i class="fas fa-times"></i></a>
                                </div>
                                <div class="col-sm-11 d-flex justify-content-center align-items-center">
                                    <textarea class="form-control" rows="1" name="category_{{$category->getId()}}" type="text" style="resize:none;width:80%;margin:3px 0">{{$category->getName()}}</textarea>
                                </div>
                            </div>
                        @endforeach
                    <input type="hidden" name="category_delete_list"  value="" id="delete_category_list">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" value="{{ csrf_token() }}">更新</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">TodoApp</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            {{-- 全タスク表示ページへのリンク --}}
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route("home")}}" class="nav-link">
                        <i class="nav-icon far fa-lightbulb"></i>
                        <p>
                            ぜんぶ
                        </p>
                    </a>
                </li>
            </ul>
            {{-- カテゴリごとの表示ページへのリンク --}}
            @foreach ($datas["category_dto_list"]->getList() as $category)
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route("category", ["category_name" => $category->getName()])}}" class="nav-link">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>
                                {{ $category->getName() }}
                            </p>
                        </a>
                    </li>
                </ul>
            @endforeach
            {{-- カテゴリ編集へのリンク --}}
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#categoryModal">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            カテゴリ編集
                        </p>
                    </a>
                </li>
            </ul>
            {{-- アーカイブへのリンク --}}
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{route('completed_todo')}}" class="nav-link">
                        <i class="nav-icon far fa-check-circle"></i>
                        <p>
                            おわったタスク
                        </p>
                    </a>
                </li>
            </ul>
            {{-- ゴミ箱ページへのリンク --}}
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{route('deleted_todo')}}" class="nav-link">
                        <i class="nav-icon fas fa-trash-alt"></i>
                        <p>
                            やめたタスク
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
<!-- /.sidebar -->
</aside>


<!-- jQuery -->
<script src="/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    //モーダルを閉じたときに見た目だけ削除していたカテゴリを再表示する、削除リストも空にする
    $('#categoryModal').on('hidden.bs.modal', function () {
        $('#category_form_container').children().each(function(i, e){
            $(e).show();
        })

        $('#delete_category_list').val("");
    })

    //削除ボタンがクリックされたカテゴリのidをdelete_category_listのvalueにカンマ区切りで入れて列を消す
    function appendToDeleteCategoryList(category_id){
        $('#category_'+category_id).hide();

        var list_str = $('#delete_category_list').val();
        if (list_str != "") {
            list_str += "," + category_id;
        } else {
            list_str += category_id;
        }
        $('#delete_category_list').val(list_str);
    }

</script>
