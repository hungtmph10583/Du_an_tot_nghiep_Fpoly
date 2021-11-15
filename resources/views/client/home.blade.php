@section('title', 'Trang chủ')
@extends('layouts.client.main')
@section('content')
	<!-- content -->
	<div class="section-mt"></div>
    <div class="sliders">
        <div class="swiper slider-container">
            <div class="swiper-wrapper wrapper">
                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="{{ asset('client-theme/images/slide1.jpg')}}" alt="">
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="{{ asset('client-theme/images/slide2.jpg')}}" alt="">
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="{{ asset('client-theme/images/slide3.jpg')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <section class="search">
        <div class="container">
            <form action="" class="search-form">
                <div class="form-field">
                    <input type="search" class="form-input" id="search-box" placeholder=" ">
                    <label for="search" class="form-label"><i class="fas fa-search"></i> search here...</label>
                </div>
                <!-- <button for="search-box">
                    <i class="fas fa-search"></i>
                </button> -->
            </form>
        </div>
    </section>
    <!-- section category -->
    <section class="categories">
        <!-- <h1 class="heading">Danh mục thú cưng của chúng tôi</h1>
        <div class="heading-hr"></div> -->
        <div class="category-container">
            @foreach($category as $category)
                @if($category->show_slide == 1 && $category->category_type_id == 1)
                <div class="category-item">
                    <div class="thumbnail">
                        <a href="#"><img src="{{asset( 'storage/' . $category->image)}}" alt=""></a>
                    </div>
                    <span class="category-name">{{$category->name}}</span>
                </div>
                @endif
            @endforeach
        </div>
        <!-- <div class="details">
            <button><a href="./category.html">xem thêm <i class="fas fa-chevron-right"></i></a></button>
        </div> -->
    </section>
    <!-- banner -->
    <div class="banner">
        <div class="banner-container">
            <div class="banner-image">
                <img src="{{ asset('client-theme/images/banner.jpg')}}" alt="">
            </div>
            <div class="banner-content">
                <!-- <h2 class="title">
                    our slogan is <span>( Thịt chó muôn năm )</span>
                </h2>
                <sapn class="description">Giả cầy bảy món Lorem ipsum dolor, sit amet consectetur adipisicing elit. Beatae, ratione sed vero deserunt voluptatibus eius molestiae non doloribus voluptate architecto error reprehenderit labore ullam adipisci, eligendi eveniet. Qui,
                    exercitationem odit!</sapn>
                <a href="#"></a> -->
            </div>
        </div>
    </div>
    <!-- section product -->
    <section class="products">
        <div class="heading">
            <span class="heading-title">Sản phẩm</span>
        </div>
        <div class="product-container">
            @foreach($product as $product)
            <div class="product-item">
                <div class="item-top">
                    <div class="product-thumbnail">
                    <a href="{{route('client.product.detail', ['id' => $product->id])}}">
                        <img src="{{asset( 'storage/' . $product->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                    </div>
                    <div class="product-extra">
                        <form action="{{route('buyNow')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="product_id_hidden" value="{{$product->id}}">
                            <input type="hidden" name="discount_price" value="{{$product->discount}}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-buyNow">Mua hàng</button>
                        </form>
                    </div>
                </div>
                <div class="item-bottom">
                    <div class="product-info">
                        <a href="{{route('client.product.detail', ['id' => $product->id])}}" class="name">{{$product->name}}</a>
                        @if($product->discount == '')
                            <span class="price">{{number_format($product->price)}}đ</span>
                        @else
                            <span class="price">
                                <?php
                                    echo number_format($product->price - $product->discount).'đ';
                                ?>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            <!-- <div class="product-item">
                <div class="item-top">
                    <div class="product-lable">
                        <p class="sale">
                            <span>Giảm: 155.000 vnd</span>
                        </p>
                    </div>
                    <div class="product-thumbnail">
                        <a href="./detail.html">
                            <img src="{{ asset('client-theme/images/cate-bird.jpg')}}" alt="">
                        </a>
                    </div>
                    <div class="product-extra">
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-eye"></a>
                        <a href="#" class="fas fa-shopping-cart"></a>
                    </div>
                </div>
                <div class="item-bottom">
                    <div class="product-info">
                        <a href="#" class="name">Vẹt bảy màu</a>
                        <span class="category">Danh mục<a href="#" class="link-ct">Bird</a></span>
                        <span class="price">30.000.000 VND</span>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="details">
            <button><a href="{{route('client.product.index')}}">xem thêm <i class="fas fa-chevron-right"></i></a></button>
        </div>
    </section>
    <!-- member -->
    <!-- <section class="members" id="members">
        <div class="member-container">
            <div class="member-item">
                <div class="avatar"><img src="{{ asset('client-theme/images/cold.jpg')}}" alt=""></div>
                <h3 class="name">Mạnh Hùng</h3>
                <div class="member-extra">
                    <span>Trưởng nhóm</span>
                    <span>Back-end</span>
                    <span>Front-end</span>
                </div>
                <div class="item-extra">
                    <ul>
                        <li>
                            <a href="#" class="fab fa-facebook-f"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-at"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-phone-alt"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="member-item">
                <div class="avatar"><img src="{{ asset('client-theme/images/cold.jpg')}}" alt=""></div>
                <h3 class="name">Mạnh Hùng</h3>
                <div class="member-extra">
                    <span>Trưởng nhóm</span>
                    <span>Back-end</span>
                    <span>Front-end</span>
                </div>
                <div class="item-extra">
                    <ul>
                        <li>
                            <a href="#" class="fab fa-facebook-f"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-at"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-phone-alt"></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="member-item">
                <div class="avatar"><img src="{{ asset('client-theme/images/cold.jpg')}}" alt=""></div>
                <h3 class="name">Mạnh Hùng</h3>
                <div class="member-extra">
                    <span>Trưởng nhóm</span>
                    <span>Back-end</span>
                    <span>Front-end</span>
                </div>
                <div class="item-extra">
                    <ul>
                        <li>
                            <a href="#" class="fab fa-facebook-f"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-at"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-phone-alt"></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="member-item">
                <div class="avatar"><img src="{{ asset('client-theme/images/cold.jpg')}}" alt=""></div>
                <h3 class="name">Mạnh Hùng</h3>
                <div class="member-extra">
                    <span>Trưởng nhóm</span>
                    <span>Back-end</span>
                    <span>Front-end</span>
                </div>
                <div class="item-extra">
                    <ul>
                        <li>
                            <a href="#" class="fab fa-facebook-f"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-at"></a>
                        </li>
                        <li>
                            <a href="#" class="fas fa-phone-alt"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section> -->
    <!-- section new&new -->
    <section class="blogs">
        <h1 class="heading">Bài viết & tin tức</h1>
        <div class="heading-hr"></div>
        <div class="blog-container">
            <div class="blog-item">
                <div class="item-top">
                    <div class="thumbnail">
                        <a href="#"><img src="{{ asset('client-theme/images/blog12.jpg')}}" alt=""></a>
                    </div>
                </div>
                <div class="item-bottom">
                    <div class="item-extra">
                        <ul>
                            <li>
                                <i class="fas fa-user"></i>
                                <span>Tác giả: </span>
                                <span class="author">Big Boss</span>
                            </li>
                            <li class="middle">
                                <i class="far fa-calendar-alt"></i>
                                <span>15/10/2021</span>
                            </li>
                            <li>
                                <i class="far fa-comments"></i>
                                <span class="comment">1</span>
                                <span>Bình luận</span>
                            </li>
                        </ul>
                    </div>
                    <h1 class="title">the lone bird in snow</h1>
                    <a href="#" class="btn">Chi tiết</a>
                </div>
            </div>
            <div class="blog-item">
                <div class="item-top">
                    <div class="thumbnail">
                        <a href="#"><img src="{{ asset('client-theme/images/blog12.jpg')}}" alt=""></a>
                    </div>
                </div>
                <div class="item-bottom">
                    <div class="item-extra">
                        <ul>
                            <li>
                                <i class="fas fa-user"></i>
                                <span>Tác giả: </span>
                                <span class="author">Big Boss</span>
                            </li>
                            <li class="middle">
                                <i class="far fa-calendar-alt"></i>
                                <span>15/10/2021</span>
                            </li>
                            <li>
                                <i class="far fa-comments"></i>
                                <span class="comment">1</span>
                                <span>Bình luận</span>
                            </li>
                        </ul>
                    </div>
                    <h1 class="title">the lone bird in snow</h1>
                    <a href="#" class="btn">Chi tiết</a>
                </div>
            </div>
        </div>
        <div class="details">
            <button><a href="./category.html">xem thêm <i class="fas fa-chevron-right"></i></a></button>
        </div>
    </section>
	<!-- content -->
@endsection