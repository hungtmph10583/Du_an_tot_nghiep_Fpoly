@section('title', 'Giỏ hàng')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/blog.css')}}">
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
<!-- section product -->
<section class="blogs">
    <div class="blog-container">
        @foreach($blog as $value)
        <div class="blog-item">
            <div class="item-top">
                <div class="thumbnail">
                    <a href="{{route('client.blog.detail', ['id' => $value->id])}}">
                    <img src="{{asset( 'storage/' . $value->image)}}" alt="Bài viết này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
            </div>
            <div class="item-bottom">
                <div class="item-extra">
                    <ul>
                        <li>
                            <i class="fas fa-user"></i>
                            <span>Tác giả: </span>
                            <span class="author">{{$value->user->name}}</span>
                        </li>
                        <li class="middle">
                            <i class="far fa-calendar-alt"></i>
                            <span>
                                {{date_format($value->created_at,"d/m/Y H:i:s")}}
                            </span>
                        </li>
                        <li>
                            <i class="far fa-comments"></i>
                            <span class="comment">1</span>
                            <span>Bình luận</span>
                        </li>
                    </ul>
                </div>
                <h1 class="title">{{$value->title}}</h1>
                <a href="{{route('client.blog.detail', ['id' => $value->id])}}" class="btn">Chi tiết</a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="paging">
    {{ $blog->links('vendor.pagination.custom') }}
    </div>
</section>
<!-- scroll to top -->
@endsection