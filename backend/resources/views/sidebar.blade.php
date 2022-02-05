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
                    <a href="#" class="nav-link">
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
                        <a href="#" class="nav-link">
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
                    <a href="#" class="nav-link">
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
                    <a href="#" class="nav-link">
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
                    <a href="#" class="nav-link">
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

