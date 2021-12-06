@section('title', 'Thông tin phụ kiện')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/productDetail.css')}}">
@endsection
<!-- content -->
<!-- section detail product -->
<section class="detail-products">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <a href="{{route('client.accessory.index')}}">Phụ kiện</a>
        <span>{{$model->name}}</span>
    </div>
    <div class="product-container">
        <div class="product-item-image">
            <div class="main-image" id="main-image">
                <img src="{{asset( 'storage/' . $model->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" id=featured>
            </div>
            <div class="thumbnails">
                <div id="slide_prev_thumbnail"><i class="fas fa-chevron-left"></i></div>
                <div class="slide-thumbnails" id="slide-thumbnails">
                <div>
                    <img src="{{asset( 'storage/' . $model->image)}}" class="thumbnail_gallery_product active" alt="error">
                </div>    
                @foreach ($model->galleries as $gl)
                    <div><img src="{{asset('storage/' . $gl->image_url)}}" class="thumbnail_gallery_product" alt="error"></div>
                @endforeach    
                </div>
                <div id="slide_next_thumbnail"><i class="fas fa-chevron-right"></i></div>
            </div>
        </div>
        <div class="product-item-description">
                <h1 class="name">{{$model->name}}</h1>
                <div class="product-extra-icons">
                    <ul>
                        <li class="product-extra-star">
                            <span class="star">
                                @for($count=1; $count<=5; $count++)
                                    @if($count <= $rating)
                                        <i class="fas fa-star rating"></i>
                                    @elseif($countReview == 0)
                                        <i class="fas fa-star rating"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </span>
                        </li>
                        <li>
                            <i class="far fa-comments"></i>
                            <span class="number">{{$countReview}}</span>
                            <span>Đánh giá</span>
                        </li>
                        <li>
                            <span class="number">1532</span>
                            <span>Đã bán</span>
                        </li>
                    </ul>
                </div>
                <div class="item-extra">
                    <h6>Giá bán</h6>
                    @if($model->discount == '')
                        <span class="price">{{number_format($model->price)}}đ</span>
                    @else
                        <span class="discount">{{number_format($model->price)}}đ</span>
                        <span class="price">
                            <?php
                                echo number_format($model->price - $model->discount).'đ';
                            ?>
                        </span>
                    @endif
                </div>
                <div class="item-extra">
                    <h6>Danh mục</h6>
                    <span class="box">{{$model->category->name}}</span>
                </div>
            <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="product_id_hidden" value="{{$model->id}}">
                <input type="hidden" name="discount_price" value="{{$model->discount}}">
                <input type="hidden" name="category_id" value="{{$model->category_id}}">
                <div class="item-extra">
                    <h6>Số lượng</h6>
                    <div class="quantity">
                        <input class="minus @if($model->quantity > 0) is-form @else is-form-none @endif" type="button" value="-">
                        <input aria-label="quantity" class="input-qty" name="quantity" type="number"
                            @if($model->quantity > 0) 
                                max="{{$model->quantity}}" min="1" value="1"
                            @else
                                value="0" disabled
                            @endif >
                            <input type="hidden" name="maxQuantity" value="{{$model->quantity}}">
                        <input class="plus @if($model->quantity > 0) is-form @else is-form-none @endif" type="button" value="+">
                    </div>
                    <span style="padding-left: 2rem;color: var(--text-color);font-size: 1.5rem;">
                        @if($model->quantity > 0)
                            {{$model->quantity}} sản phẩm có sẵn
                        @else
                            Hết hàng
                        @endif
                    </span>
                </div>
                <?php
                    $content = Cart::content();
                ?>
                <!-- @foreach($content as $ct)
                    @if($ct->id == $model->id)
                        @if($ct->qty>= $model->quantity)
                            <button disabled class="btn">Thêm vào giỏ hàng</button>
                        @else
                        @endif
                    @endif
                @endforeach -->
                <input type="hidden" name="product_type" value="2">
                            <button type="submit" class="btn">Thêm vào giỏ hàng</button>
            </form>
            <form action="{{route('buyNow')}}" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="product_id_hidden" value="{{$model->id}}">
                <input type="hidden" name="discount_price" value="{{$model->discount}}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn">Mua hàng</button>
            </form>
        </div>
    </div>
</section>
<section class="product-tab">
    <div class="product-tabs-container">
        <div class="product-list-tabs">
            <button id="btn-product-description" class="one">Mô tả sản phẩm</button>
            <button id="btn-reviews" class="three">Đánh giá</button>
        </div>
        <div class="product-tabs-content product-description active">
            <h5>Product desription</h5>
            <p>Đặc điểm nhận dạng: Lông vũ sặc sỡ, hai mắt, hai chân, hai cánh</p>
            <p>Cân nặng 5kg</p>
            <p>Giống đực</p>
            <p>Chủng loại: vẹt Bắc Âu</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat enim rerum reiciendis aperiam? Veniam explicabo distinctio quod, pariatur quasi dolorum assumenda accusantium iusto voluptatum voluptate modi dolore. Id, tempora consequatur.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat enim rerum reiciendis aperiam? Veniam explicabo distinctio quod, pariatur quasi dolorum assumenda accusantium iusto voluptatum voluptate modi dolore. Id, tempora consequatur.</p>
        </div>
        <div class="product-tabs-content reviews">
            <h5>Phản hồi từ khách hàng</h5>
            <div class="review-content comment">
                <span class="star">
                    @for($count=1; $count<=5; $count++)
                        @if($count <= $rating)
                            <i class="fas fa-star rating"></i>
                        @elseif($countReview == 0)
                            <i class="fas fa-star rating"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </span>
                <span class="total-start">Đựa trên {{$countReview}} nhận xét</span>
                <button id="btn-write-comment">Viết nhận xét</button>
                <div class="clear-both"></div>
            </div>
            <div class="write-comment">
                <p>Viết đánh giá</p>
                <form action="{{route('client.accessory.post_review')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="product_type" value="2">
                    <input type="hidden" name="product_id" value="{{$model->id}}">
                    <div class="form-group">
                        <label for="">Name</label>
                        @if(Auth::check())
                        <input type="text" name="name" placeholder="Nhập vào họ tên" value="{{Auth::user()->name}}">
                        @else
                        <input type="text" name="name" placeholder="Nhập vào họ tên">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        @if(Auth::check())
                        <input type="text" name="email" placeholder="Nhập vào email" value="{{Auth::user()->email}}">
                        @else
                        <input type="text" name="email" placeholder="Nhập vào email">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Đánh giá sao</label>
                        <span class="star-widget">
                            <input type="radio" value="5" name="rating" id="rate-5">
                            <label for="rate-5" class="fas fa-star"></label>
                            <input type="radio" value="4" name="rating" id="rate-4">
                            <label for="rate-4" class="fas fa-star"></label>
                            <input type="radio" value="3" name="rating" id="rate-3">
                            <label for="rate-3" class="fas fa-star"></label>
                            <input type="radio" value="2" name="rating" id="rate-2">
                            <label for="rate-2" class="fas fa-star"></label>
                            <input type="radio" value="1" name="rating" id="rate-1">
                            <label for="rate-1" class="fas fa-star"></label>
                        </span>
                        <div class="clear-both"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Nội dung đánh giá</label>
                        <textarea name="comment" id="" cols="30" rows="10" placeholder="Viết nội dung dánh giá của bạn tại đây"></textarea>
                    </div>
                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
            @foreach($review as $rv)
                @if($rv->product_id == $model->id)
                <div class="review-content">
                    <div class="star">
                        @for($count=1; $count<=5; $count++)
                            @if($count <= $rv->rating)
                                <i class="fas fa-star rating"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="name-custom-review">{{$rv->user->name}}</p>
                    <span class="date-custom-review">{{$rv->created_at->diffForHumans()}}</span>
                    <div class="content">
                        <p>{{$rv->comment}}</p>
                    </div>
                </div>
                @endif
            @endforeach
            @if($countReview < 1)
            <div class="review-content">
                <div class="content">
                    <p>Chưa có bình luận nào</p>
                </div>
            </div>
            @endif
            <div class="paging">
            {{ $review->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</section>
<section class="product_slide" id="product">
    <h1 class="heading"> Sản Phẩm Tương Tự </h1>
    <div class="swiper product-slider product-container">
        <div class="swiper-wrapper">
            @foreach($product_slide as $pro_S)
            <div class="swiper-slide product-item">
                <div class="item-lable">
                    <div class="product-thumbnail">
                        <a href="{{route('client.product.detail', ['id' => $pro_S->slug])}}">
                            <img src="{{asset( 'storage/' . $pro_S->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                        </a>
                    </div>
                    <div class="product-info">
                        <a href="{{route('client.product.detail', ['id' => $pro_S->slug])}}" class="name">
                            {{$pro_S->name}}
                        </a>
                        @if($pro_S->discount == '')
                            <span class="price">{{number_format($pro_S->price)}}đ</span>
                        @else
                            <span class="discount">{{number_format($pro_S->price)}}đ</span>
                            <span class="price">
                                <?php
                                    echo number_format($pro_S->price - $pro_S->discount).'đ';
                                ?>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection @section('pagejs')
<script>
    $('input.input-qty').each(function() {
        var $this = $(this),
            qty = $this.parent().find('.is-form'),
            min = Number($this.attr('min')),
            max = Number($this.attr('max'))
        if (min == 0) {
            var d = 0
        } else d = min
        $(qty).on('click', function() {
            if ($(this).hasClass('minus')) {
            if (d > min) d += -1
            } else if ($(this).hasClass('plus')) {
            var x = Number($this.val()) + 1
            if (x <= max) d += 1
            }
            $this.attr('value', d).val(d)
        })
    })

    let thumbnails = document.getElementsByClassName('thumbnail_gallery_product')
    let activeImages = document.getElementsByClassName('active')

    for (var i = 0; i < thumbnails.length; i++) {

        thumbnails[i].addEventListener('mouseover', function() {
            // console.log(activeImages)
            if (activeImages.length > 0) {
                activeImages[0].classList.remove('active')
            }
            this.classList.add('active')
            document.getElementById('featured').src = this.src
        })
    }


    let buttonRight = document.getElementById('slide_next_thumbnail');
    let buttonLeft = document.getElementById('slide_prev_thumbnail');

    buttonLeft.addEventListener('click', function() {
        document.getElementById('slide-thumbnails').scrollLeft -= 180
    })

    buttonRight.addEventListener('click', function() {
        document.getElementById('slide-thumbnails').scrollLeft += 180
    })

    let productDescription = document.querySelector('.product-description');
    let reviews = document.querySelector('.reviews');
    let writeCommment = document.querySelector('.write-comment');
    var btnPD = document.getElementById('btn-product-description');
    var btnRV = document.getElementById('btn-reviews');
    var btnRVC = document.getElementById('btn-write-comment');
    document.addEventListener('click', function(event) {
        var isClickInsidePD = btnPD.contains(event.target);
        var isClickInsideRV = btnRV.contains(event.target);
        var isClickInsideRVC = btnRVC.contains(event.target);
        if (isClickInsidePD) {
            productDescription.classList.add('active');
            reviews.classList.remove('active');
        }
        if (isClickInsideRV) {
            reviews.classList.add('active');
            productDescription.classList.remove('active');
        }
        if (isClickInsideRVC) {
            writeCommment.classList.toggle('active');
        }
    });

    var swiper = new Swiper(".product-slider", {
            spaceBetween: 10,
            centeredSlides: true,
            // autoplay: {
            //     delay: 7500,
            //     disableOnInteraction: false,
            // },
            loop: true,
            breakpoints: {
                769: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                950: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1390: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
                1660: {
                    slidesPerView: 5,
                    spaceBetween: 50,
                },
            },
        });
</script>
@endsection
