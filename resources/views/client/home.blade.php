@section('title', 'Trang chủ')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
@endsection
<!-- <div class="supper">
        <div class="alert">
        </div>
    </div> -->
<!-- content -->
<div class="sliders">
    <div class="swiper slider-container">
        <div class="swiper-wrapper wrapper">
            @foreach($slide as $sl)
            @if($sl->status == 1)
            <div class="swiper-slide slide">
                <div class="image">
                    <img src="{{asset( 'storage/' . $sl->image)}}"
                        alt="slide này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<!-- section category -->
<section class="categories">
    <div class="category-container">
        @foreach($category as $category)
        @if($category->show_slide == 1 && $category->category_type_id == 1)
        <div class="category-item">
            <div class="thumbnail">
                <a href="{{route('client.product.index')}}?cate_id={{$category->id}}"><img
                        src="{{asset( 'storage/' . $category->image)}}" alt=""></a>
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
<div class="banner" style="background-image: url({{ asset('client-theme/images/banner.jpg')}});">
    <h6 class="title"><a href="#">LoliPetVn@gmail.com</a></h6>
    <h4> Chào Mừng Đến Với Website Của Chúng Tôi </h4>
    <p class="description">Giả cầy bảy món Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur aliquam ullam ipsum
        autem labore odio illum reiciendis.</p>
    <a href="#"></a>
</div>
<!-- section product -->
<section class="products" id="product">
    <h1 class="heading-center"> Shop bán các loại thú cưng </h1>
    <div class="product-container">
        @foreach($product as $p)
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                </div>
                <div class="product-thumbnail">
                    <a href="{{route('client.product.detail', ['id' => $p->slug])}}">
                        <img src="{{asset( 'storage/' . $p->image)}}"
                            alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="product-extra">
                    <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id_hidden" value="{{$p->id}}">
                        <input type="hidden" name="product_type" value="1">
                        <input type="hidden" name="discount_price" value="{{$p->discount}}">
                        <input type="hidden" name="category_id" value="{{$p->category_id}}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-buyNow">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
            <div class="item-bottom">
                <div class="product-info">
                    <a href="{{route('client.product.detail', ['id' => $p->slug])}}" class="name">{{$p->name}}</a>
                    @if($p->discount == '')
                    <span class="price">{{number_format($p->price)}}đ</span>
                    @else
                    <span class="discount">{{number_format($p->price)}}đ</span>
                    <span class="price">
                        <?php
                        echo number_format($p->price - $p->discount) . 'đ';
                        ?>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="details">
        <button><a href="{{route('client.product.index')}}">xem thêm <i class="fas fa-chevron-right"></i></a></button>
    </div>
</section>
<!-- section acsesory -->
<section class="products">
    <h1 class="heading-center"> Phụ kiện thú cưng </h1>
    <div class="product-container">
        @foreach($accessory as $ac)
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                </div>
                <div class="product-thumbnail">
                    <a href="{{route('client.accessory.detail', ['id' => $ac->slug])}}">
                        <img src="{{asset( 'storage/' . $ac->image)}}"
                            alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="product-extra">
                    <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id_hidden" value="{{$ac->id}}">
                        <input type="hidden" name="product_type" value="2">
                        <input type="hidden" name="discount_price" value="{{$ac->discount}}">
                        <input type="hidden" name="category_id" value="{{$ac->category_id}}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-buyNow">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
            <div class="item-bottom">
                <div class="product-info">
                    <a href="{{route('client.accessory.detail', ['id' => $ac->slug])}}" class="name">{{$ac->name}}</a>
                    @if($p->discount == '')
                    <span class="price">{{number_format($ac->price)}}đ</span>
                    @else
                    <span class="discount">{{number_format($ac->price)}}đ</span>
                    <span class="price">
                        <?php
                        echo number_format($ac->price - $ac->discount) . 'đ';
                        ?>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="details">
        <button><a href="{{route('client.accessory.index')}}">xem thêm <i class="fas fa-chevron-right"></i></a></button>
    </div>
</section>
<!-- member -->
<!-- <section class="members" id="members">
        <div class="swiper members member-container">
            <div class="member-item">
                <div class="avatar"><img src="{{ asset('client-theme/images/hotboy.jpg')}}" alt=""></div>
                <div class="member-extra">
                    <h3 class="name">Mạnh Hùng</h3>
                    <span>Trưởng nhóm</span>
                    <span>Back-end</span>
                    <span>Front-end</span>
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
        </div>
    </section> -->
<!-- section new&new -->
<section class="blogs">
    <h1 class="heading-center">Bài viết mới nhất</h1>
    <div class="blog-container">
        @foreach($blog as $blog)
        <div class="blog-item">
            <div class="item-top">
                <div class="thumbnail">
                    <a href="{{route('client.blog.detail', ['id' => $blog->slug])}}">
                        <img src="{{asset( 'storage/' . $blog->image)}}"
                            alt="Bài viết này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="link_blog">
                    <a href="{{route('client.blog.detail', ['id' => $blog->slug])}}" class="btn-gray">Chi tiết</a>
                </div>
            </div>
            <div class="item-bottom">
                <h1 class="title">{{$blog->title}}</h1>
                <div class="item-extra">
                    <ul>
                        <li>
                            <i class="fas fa-user"></i>
                            <span>Tác giả: </span>
                            <span class="author">{{$blog->user->name}}</span>
                        </li>
                        <li class="middle">
                            <i class="far fa-calendar-alt"></i>
                            <span class="author">{{$blog->created_at->diffForHumans()}}</span>
                        </li>
                        <!-- <li>
                                <i class="far fa-comments"></i>
                                <span class="comment">1</span>
                                <span>Bình luận</span>
                            </li> -->
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="details">
        <button><a href="{{route('client.blog.index')}}">xem thêm <i class="fas fa-chevron-right"></i></a></button>
    </div>
</section>
<!-- content -->
@endsection