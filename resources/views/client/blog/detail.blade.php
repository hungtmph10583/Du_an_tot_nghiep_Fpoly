@section('title', 'Tin tức')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/newDetail.css')}}">
@endsection
	<!-- content -->
<div class="section-mt"></div>
<!-- <section class="search">
    <div class="container">
        <form action="" class="search-form">
            <div class="form-field">
                <input type="search" class="form-input" id="search-box" placeholder=" ">
                <label for="search" class="form-label"><i class="fas fa-search"></i> search here...</label>
            </div>
        </form>
    </div>
</section> -->
<section class="detail-blog">
    <div class="blog-container">
        <div class="blog-image">
            <img src="{{asset( 'storage/' . $blog->image)}}" alt="Bài viết này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
        </div>
        <div class="blog-description">
            <h1 class="title">{{$blog->title}}</h1>
            <div class="blog-extra">
                <ul>
                    <li>
                        <i class="far fa-calendar-alt"></i>
                        <span>{{date_format($blog->created_at,"d/m/Y H:i:s")}}</span>
                    </li>
                    <li class="middle">
                        <i class="far fa-comments"></i>
                        <span class="comment">1</span>
                        <span>Bình luận</span>
                    </li>
                    <li>
                        <i class="far fa-user"></i>
                        <span>Tác giả: </span>
                        <span class="author">{{$blog->user->name}}</span>
                    </li>
                </ul>
            </div>
            <div class="content">
                <p>{{$blog->content}}</p>
            </div>
            <div class="blog-navigation">
                <div class="prev">
                    <a href="#">Bài viết trước</a>
                </div>
                <div class="next">
                    <a href="#">Bài viết khác</a>
                </div>
            </div>
            <div class="blog-comment">
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
            </div>
        </div>
    </div>
</section>
<!-- scroll to top -->
@endsection