@section('title', 'Chi tiết bài viết')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/blogDetail.css')}}">
@endsection
	<!-- content -->
<section class="detail-blog">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <a href="{{route('client.blog.index')}}">Bài viết</a>
        <span>{{$blog->title}}</span>
    </div>
    <h1 id="heading">{{$blog->title}}</h1>
    <div class="blog-container">
        <div class="blog-description">
            <!-- <h1 class="title">{{$blog->title}}</h1> -->
            <div class="blog-extra">
                <ul>
                    <li>
                        <i class="far fa-calendar-alt"></i>
                        <span>{{$blog->created_at->format('d/m/Y')}}</span>
                    </li>
                    <li class="middle">
                        <i class="far fa-comments"></i>
                        <span class="comment">1</span>
                        <span>Bình luận</span>
                    </li>
                    <li>
                        <i class="far fa-user"></i>
                        <span>Tác giả: </span>
                        <strong class="author">{{$blog->user->name}}</strong>
                    </li>
                </ul>
            </div>
            <div class="content">
                {!!$blog->content!!}
            </div>
            <div class="blog-navigation">
                <div class="prev">
                    <a href="#">Bài viết trước</a>
                </div>
                <div class="next">
                    <a href="#">Bài viết khác</a>
                </div>
            </div>
            <!-- <div class="blog-comment">
                <div class="blog-comment-item">
                    <h5 class="total">
                        <i class="far fa-comments"></i>
                        <span class="number-comment">2</span>
                        <span>Comment</span>
                    </h5>
                    <ul>
                        <li>
                            <div class="comments-section">
                                <div class="comment-extra">
                                    <ul>
                                        <li>
                                            <i class="far fa-calendar-alt"></i>
                                            <span>15/10/2021</span>
                                        </li>
                                        <li>
                                            <i class="far fa-user"></i>
                                            <span>Tác giả: </span>
                                            <span class="author">Big Boss</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="comment-description">
                                    <p>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veniam ipsa rem repellendus doloribus incidunt sequi quibusdam placeat dolores, voluptatibus deleniti ipsam soluta sapiente voluptatem pariatur porro modi fugit officiis iste.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="comments-section">
                                <div class="comment-extra">
                                    <ul>
                                        <li>
                                            <i class="far fa-calendar-alt"></i>
                                            <span>15/10/2021</span>
                                        </li>
                                        <li>
                                            <i class="far fa-user"></i>
                                            <span>Tác giả: </span>
                                            <span class="author">Big Boss</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="comment-description">
                                    <p>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veniam ipsa rem repellendus doloribus incidunt sequi quibusdam placeat dolores, voluptatibus deleniti ipsam soluta sapiente voluptatem pariatur porro modi fugit officiis iste.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="blog-comment-item">
                    <form action="">
                        <h5>Viết bình luận</h5>
                        <div class="form-comment">
                            <div class="form-comment-item">
                                <input type="text" name="name" id="" placeholder="Name">
                                <input type="text" name="email" id="" placeholder="Email">
                            </div>
                            <textarea name="comment" id="" cols="30" rows="10" placeholder="Bình luận"></textarea>
                        </div>
                        <button class="btn">Gửi bình luận</button>
                    </form>
                </div>
            </div> -->
            <div class="customer_reviews">
                <h2>Đánh giá từ khách hàng</h2>
                <div class="container_customer_review">
                    <div class="see_review">
                        <div class="totail_rating">
                            <span class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                            <span>Rating: 4.8 (29 đánh giá)</span>
                        </div>
                        <div class="content_review">
                            <div class="box-review">
                                <div class="calendar">
                                    <span>30/2</span>
                                    <span>2020</span>
                                </div>
                                <div class="content">
                                    <div class="title">Great</div>
                                    <span class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </span>
                                    <div class="review_body">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. At, ad. Vel earum temporibus aut suscipit in accusantium consequatur pariatur! Esse rerum modi itaque ipsam reprehenderit recusandae sunt deleniti accusamus quisquam.
                                    </div>
                                    <div class="review_author">
                                        Mạnh Hùng
                                    </div>
                                </div>
                            </div>
                            <div class="box-review">
                                <div class="calendar">
                                    <span>22/2</span>
                                    <span>2020</span>
                                </div>
                                <div class="content">
                                    <div class="title">Great</div>
                                    <span class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </span>
                                    <div class="review_body">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. At, ad. Vel earum temporibus aut suscipit in accusantium consequatur pariatur! Esse rerum modi itaque ipsam reprehenderit recusandae sunt deleniti accusamus quisquam.
                                    </div>
                                    <div class="review_author">
                                        Mạnh Hùng
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_review">
                        <h3>Gửi đánh giá của bạn</h3>
                        <form action="">
                            <div class="box">
                                <div class="col">
                                    <input type="text" placeholder="Name" name="name">
                                </div>
                            </div>
                            <div class="box">
                                <div class="col">
                                    <input type="text" placeholder="Email" name="email">
                                </div>
                            </div>
                            <div class="box">
                                <div class="col">
                                    <input type="text" placeholder="Review Title" name="title">
                                </div>
                            </div>
                            <div class="box">
                                <div class="col-star">
                                    <label for="">Đánh giá:</label>
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
                            </div>
                            <div class="box">
                                <div class="col">
                                    <textarea name="content" placeholder="Review" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="box-last">
                                <button>Gửi đánh giá của bạn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- scroll to top -->
@endsection