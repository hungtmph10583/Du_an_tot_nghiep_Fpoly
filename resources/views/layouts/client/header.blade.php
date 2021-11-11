<header class="header-wrapper">
    <div class="header-top-bar">
        <div class="container">
            <div class="row">
                <ul class="header-item-left">
                    <li>
                        <a href="#">
                            <i class="fas fa-envelope"></i>
                            <span>lolipet@gmail.com</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-phone-alt"></i>
                            <span>033 612 6726</span>
                        </a>
                    </li>
                </ul>
                <div class="header-item none"></div>
                <ul class="header-item">
                    @if(Auth::check())
                    @hasanyrole('admin|manage')
                    <li>
                        <a href="{{route('dashboard.index')}}">
                        <i class="fas fa-cogs"></i>
                            <span>Đăng nhập quản trị</span>
                        </a>
                    </li>
                    @endhasanyrole
                    <li>
                        <a href="{{route('client.customer.info')}}">
                            <i class="fas fa-user"></i>
                            <span>{{Auth::user()->name}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('logout')}}">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('login')}}">
                            <i class="fas fa-user"></i>
                            <span>Tài khoản</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('login')}}">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="header-middle-bar">
        <div class="container">
            <div class="row">
                <div class="header-item icon-bars">
                    <div class="fas fa-bars" id="menu-btn"></div>
                </div>
                <div class="header-item none"></div>
                <div class="header-item">
                    <a href="#" class="logo">
                        <i class="fas fa-paw"></i> <b> LOLI<span>PET</span></b>
                    </a>
                </div>
                <div class="header-item">
                    <nav class="navbar">
                        <ul class="nav-item">
                            <li>
                                <a href="{{route('client.home')}}">Trang chủ</a>
                            </li>
                            <li>
                                <a href="./introduce.html">Giới thiệu</a>
                            </li>
                            <li>
                                <a href="./index.html">Danh mục</a>
                            </li>
                            <li>
                                <a href="{{route('client.product.index')}}">Sản phẩm</a>
                            </li>
                            <li>
                                <a href="./blog.html">Tin tức</a>
                            </li>
                            <li>
                                <a href="./contact.html">Liên hệ</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header-item icons">
                    <!-- <div class="cart">
                        <i class="fas fa-heart"></i>
                    </div> -->
                    <div class="cart">
                        <a href="{{route('client.cart.index')}}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="title">Giỏ hàng</span>
                            <span class="btn-number">
                                <?php
                                    $count = Cart::content()->count();
                                ?>
                                    {{$count}}
                            </span>
                        </a>
                    </div>
                </div>
                <!--  -->
                <!-- <div class="shopping-cart">
                    <div class="box">
                        <i class="fas fa-trash-alt"></i>
                        <img src="{{ asset('client-theme/images/002.jpg')}}" alt="">
                        <div class="content">
                            <h3>pit bull</h3>
                            <span class="price">12.500 VND</span> <br>
                            <span class="quantity">số lượng : 2</span>
                        </div>
                    </div>
                    <div class="box">
                        <i class="fas fa-trash-alt"></i>
                        <img src="{{ asset('client-theme/images/003.jpg')}}" alt="">
                        <div class="content">
                            <h3>supper dog pit bull</h3>
                            <span class="price">12.500 VND</span> <br>
                            <span class="quantity">số lượng : 2</span>
                        </div>
                    </div>
                    <div class="box">
                        <i class="fas fa-trash-alt"></i>
                        <img src="{{ asset('client-theme/images/004.jpg')}}" alt="">
                        <div class="content">
                            <h3>pit bull</h3>
                            <span class="price">12.500 VND</span> <br>
                            <span class="quantity">số lượng : 2</span>
                        </div>
                    </div>
                    <div class="total">tổng cộng : 24.000 VND</div>
                    <a href="#" class="btn">xem giỏ hàng</a>
                    <a href="#" class="btn">thanh toán</a>
                </div> -->
            </div>
        </div>
    </div>
</header>
@section('pagejs')
<!-- <script src="{{ asset('client-theme/js/script.js')}}"></script> -->
<script>
    
</script>
@endsection