@section('title', 'Quản lý tài khoản')
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
                    <a href="#" class="active">
                        <i class="fas fa-user"></i>
                        Thông tin tài khoản
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-swatchbook"></i>
                        Quản lý đơn hàng
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-heart"></i>
                        Sản phẩm yêu thích
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-star-half-alt"></i>
                        Nhận xét của tôi
                    </a>
                </li>
            </ul>
        </div>
        <div class="account-info-right">
            <div class="title">Thông tin cá nhân</div>
            <div class="group">
                <label for="">Họ & tên:</label>
                <span>{{Auth::user()->name}}</span>
            </div>
            <div class="group">
                <label for="">Số điện thoại:</label>
                <span>{{Auth::user()->phone}}</span>
            </div>
            <div class="group">
                <label for="">Email:</label>
                <span>{{Auth::user()->email}}</span>
            </div>
            <div class="group">
                <label for="">Tỉnh/Thành phố:</label>
                <span>Hà Nội</span>
            </div>
            <div class="group">
                <label for="">Quận huyện:</label>
                <span>Quận Nam Từ Liêm</span>
            </div>
            <div class="group">
                <label for="">Phường xã:</label>
                <span>Phường cầu diễn</span>
            </div>
            <div class="group">
                <label for="">Địa chỉ:</label>
                <span>{{Auth::user()->address->address}}</span>
            </div>
            <div class="group-last">
                <a href="{{route('client.customer.updateinfo')}}" class="updateinfo">Cập nhật tài khoản</a>
                <a href="{{route('changePassword')}}" class="changepassword">Đổi mật khẩu</a>
            </div>
        </div>
    </div>
</section>
	<!-- content -->
@endsection