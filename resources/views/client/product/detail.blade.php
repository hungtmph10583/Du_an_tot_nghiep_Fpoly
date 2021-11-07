@section('title', 'Chi tiết sản phẩm') @extends('layouts.client.main') @section('content')
<!-- content -->
<div class="section-mt"></div>
<!-- section detail product -->
<section class="detail-products">
    <div class="product-container">
        <div class="product-item-image">
            <div class="main-image">
                <img src="{{asset( 'storage/' . $model->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" id="img-main">
            </div>
            <ul class="thumbnail">
                <li>
                    <img src="{{asset( 'storage/' . $model->image)}}" onclick="changeImage('0')" id="0" alt="">
                </li>
                @foreach ($model->galleries as $gl)
                <li>
                    <img src="{{asset('storage/' . $gl->image_url)}}" onclick="changeImage('order_no')" id="order_no" alt="">
                </li>
                @endforeach
            </ul>
        </div>
        <div class="product-item-description">
            <h1 class="name">{{$model->name}}</h1>
            <div class="product-extra-star">
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
            </div>
            <div class="product-extra-icons">
                <ul>
                    <li>
                        <i class="fas fa-eye"></i>
                        <span class="number">20</span>
                        <span>lượt xem</span>
                    </li>
                    <li>
                        <i class="far fa-comments"></i>
                        <span class="number">{{$countReview}}</span>
                        <span>Đánh giá</span>
                    </li>
                </ul>
            </div>
            <div class="item-extra">
                <h6>Giá bán</h6>
                @if($model->discount == '')
                <span class="discount">{{number_format($model->price)}}đ</span>
                @else
                <span class="price">{{number_format($model->price)}}đ</span>
                <span class="discount">{{number_format($model->discount)}}đ</span>
                @endif
            </div>
            <div class="item-extra">
                <h6>Danh mục</h6>
                <span class="box">{{$model->category->name}}</span>
            </div>
            <div class="item-extra">
                <h6>Giới tính</h6>
                <span class="box">{{$model->gender->gender}}</span>
            </div>
            <div class="item-extra">
                <h6>Giống loài</h6>
                <span class="box">{{$model->breed->name}}</span>
            </div>
            <div class="item-extra">
                <h6>Số lượng</h6>
                <div class="quantity">
                    <button class="back fas fa-minus" onclick="backQuantity()"></button>
                    <input id="quantity" min="1" max="5" name="quantity" type="number" value="1" />
                    <input type="hidden" value="{{$model->quantity}}" id="maxQuantityProduct">
                    <button class="next fas fa-plus" onclick="nextQuantity()" id="nextQty"></button>
                </div>
            </div>
            <a href="#" class="btn">Thêm vào giỏ hàng</a>
            <a href="#" class="btn">Mua hàng</a>
        </div>
    </div>
</section>
<section class="product-tab">
    <div class="product-tabs-container">
        <div class="product-list-tabs">
            <button id="btn-product-description" class="one">Mô tả sản phẩm</button>
            <button id="btn-shipping-details" class="two">Chi tiết vận chuyển</button>
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
        <div class="product-tabs-content shipping-details">
            <h5>Shipping details</h5>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat enim rerum reiciendis aperiam? Veniam explicabo distinctio quod, pariatur quasi dolorum assumenda accusantium iusto voluptatum voluptate modi dolore. Id, tempora consequatur.</p>
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
                <form action="" method="POST" enctype="multipart/form-data">
                @csrf
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
                        <label for="">Tiêu đề đánh giá</label>
                        <input type="text" name="title" placeholder="Nhập vào họ tên">
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
                    <span class="date-custom-review">{{$rv->created_at}}</span>
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
<section class="products">
    <h1 class="heading">Những sản phẩm tương tự</h1>
    <div class="heading-hr"></div>
    <div class="product-container">
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                    <p class="new">
                        <span>new</span>
                    </p>
                </div>
                <div class="product-thumbnail">
                    <a href="./detail.html">
                    <img src="{{asset( 'storage/' . $model->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
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
                    <a href="#" class="name">{{$model->name}}</a>
                    <span class="category">Danh mục<a href="#" class="link-ct">{{$model->category->name}}</a></span>
                    <span class="price">{{number_format($model->price)}} VND</span>
                </div>
            </div>
        </div>
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                    <!-- <p class="sale">
                        <span>Giảm: 155.000 vnd</span>
                    </p> -->
                </div>
                <div class="product-thumbnail">
                    <a href="#">
                        <img src="{{asset('client-theme/images/cate-bird.jpg')}}" alt="">
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
        </div>
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                    <!-- <p class="sale">
                        <span>Giảm: 155.000 vnd</span>
                    </p> -->
                </div>
                <div class="product-thumbnail">
                    <a href="#">
                        <img src="{{asset('client-theme/images/cate-bird.jpg')}}" alt="">
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
        </div>
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                    <!-- <p class="sale">
                        <span>Giảm: 155.000 vnd</span>
                    </p> -->
                </div>
                <div class="product-thumbnail">
                    <a href="#">
                        <img src="{{asset('client-theme/images/cate-bird.jpg')}}" alt="">
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
        </div>
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                    <!-- <p class="sale">
                        <span>Giảm: 155.000 vnd</span>
                    </p> -->
                </div>
                <div class="product-thumbnail">
                    <a href="./detail.html">
                        <img src="{{asset('client-theme/images/cold.jpg')}}" alt="">
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
                    <a href="#" class="name">Pitbull</a>
                    <span class="category">Danh mục<a href="#" class="link-ct">Dog</a></span>
                    <span class="price">30.000.000 VND</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection @section('pagejs')
<script>
    function changeImage(id) {
        let imagePath = document.getElementById(id).getAttribute('src');
        console.log(imagePath);
        document.getElementById('img-main').setAttribute('src', imagePath);
    }

    let productDescription = document.querySelector('.product-description');
    let shippingDetails = document.querySelector('.shipping-details');
    let reviews = document.querySelector('.reviews');
    let writeCommment = document.querySelector('.write-comment');

    var btnPD = document.getElementById('btn-product-description');
    var btnSD = document.getElementById('btn-shipping-details');
    var btnRV = document.getElementById('btn-reviews');
    var btnRVC = document.getElementById('btn-write-comment');

    document.addEventListener('click', function(event) {
        var isClickInsidePD = btnPD.contains(event.target);
        var isClickInsideSD = btnSD.contains(event.target);
        var isClickInsideRV = btnRV.contains(event.target);
        var isClickInsideRVC = btnRVC.contains(event.target);

        if (isClickInsidePD) {
            productDescription.classList.add('active');
            shippingDetails.classList.remove('active');
            reviews.classList.remove('active');
        }

        if (isClickInsideSD) {
            shippingDetails.classList.add('active');
            reviews.classList.remove('active');
            productDescription.classList.remove('active');
        }

        if (isClickInsideRV) {
            reviews.classList.add('active');
            productDescription.classList.remove('active');
            shippingDetails.classList.remove('active');
        }

        if (isClickInsideRVC) {
            writeCommment.classList.toggle('active');
        }
    });
</script>
@endsection