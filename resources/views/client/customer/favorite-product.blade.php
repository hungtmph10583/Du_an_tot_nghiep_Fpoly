@section('title', 'Sản phẩm yêu thích')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/account-info.css')}}">
@endsection
	<!-- content -->
<div class="section-mt"></div>
<section class="account-info">
    <div class="account-info-container">
        <div class="account-info-left">
            <div class="information">
                <div class="avatar">
                    <img src="{{asset( 'storage/' . Auth::user()->avatar)}}" alt="User profile picture">
                </div>
                <span class="name">{{Auth::user()->name}}</span>
            </div>
            <ul>
                <li>
                    <a href="{{route('client.customer.info')}}" class="active">
                        <i class="fas fa-user"></i>
                        Thông tin tài khoản
                    </a>
                </li>
                <li>
                    <a href="{{route('client.customer.orderHistory')}}">
                        <i class="fas fa-swatchbook"></i>
                        Quản lý đơn hàng
                    </a>
                </li>
                <li>
                    <a href="{{route('client.customer.favoriteProduct')}}">
                        <i class="fas fa-heart"></i>
                        Sản phẩm yêu thích
                    </a>
                </li>
                <li>
                    <a href="{{route('client.customer.review')}}">
                        <i class="fas fa-star-half-alt"></i>
                        Nhận xét của tôi
                    </a>
                </li>
            </ul>
        </div>
        <div class="account-info-right">
            <div class="title">Sản phẩm yêu thich</div>
            <div class="group">
                <img src="{{ asset('client-theme/images/error.jpg')}}" alt="error">
            </div>
        </div>
    </div>
</section>
	<!-- content -->
@endsection