<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('admin-theme/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(Auth::check())
                <img src="{{asset( 'storage/' . Auth::user()->avatar)}}" class="img-circle elevation-2" alt="User Image"
                    width="70" />
                @else
                <img src="{{ asset('admin-theme/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                    alt="User Image">
                @endif
            </div>
            <div class="info">
                @if(Auth::check())
                <a href="{{route('user.profile', ['id' => Auth::user()->id])}}"
                    class="d-block">{{Auth::user()->name}}</a>
                @else
                <a href="">Chua dang nhap</a>
                @endif
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div> -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}" class="nav-link">
                        <i class="fa fa-home"></i>
                        <p>
                            Trang chủ
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-money-bill-alt"></i>
                        <p>
                            Thống kê
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Doanh thu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lịch sử nhập hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <p>
                            Đơn hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('order.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tất cả đơn hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-paw"></i>
                        <p>
                            Sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('product.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sản phẩm thú cưng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('accessory.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sản phẩm phụ kiện</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đánh giá sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('coupon.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Phiếu giảm giá</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-swatchbook"></i>
                        <p>
                            Danh mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('category.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm danh mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('category.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('breed.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Giống loài</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('category.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Back Up Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-friends"></i>
                        <p>
                            Tài khoản
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('user.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        @hasanyrole('admin|manage')
                        <li class="nav-item">
                            <a href="{{route('user.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm tài khoản</p>
                            </a>
                        </li>
                        @endhasanyrole
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-newspaper"></i>
                        <p>
                            Bài viết
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('blog.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        @hasanyrole('admin|manage')
                        <li class="nav-item">
                            <a href="{{route('blog.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm bài viết</p>
                            </a>
                        </li>
                        @endhasanyrole
                        <li class="nav-item">
                            <a href="{{route('blogCategory.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh mục bài viết</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Hệ thống
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('generalSetting.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thông tin hệ thống</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('blog.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Header</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('blog.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slide</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('blog.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Banner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('blog.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Footer</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>