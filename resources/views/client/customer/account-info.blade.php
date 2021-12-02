@section('title', 'Quản lý tài khoản')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/account_info.css')}}">
@endsection
	<!-- content -->
<section class="account-info">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Quản lý tài khoản</span>
    </div>
    <div class="account_info_container">
        <div class="info_customer">
            <div class="avatar">
                <img src="{{asset( 'storage/' . Auth::user()->avatar)}}" alt="User profile picture">
                <a href="{{route('client.customer.updateinfo')}}" class="setting">Edit</a>
            </div>
            <div class="info">
                <h5>{{Auth::user()->name}}</h5>
                <p>Trưởng Nhóm</p>
            </div>
            @include('client.customer.nav_bar_customer')
        </div>
        <!-- <div class="content_page">
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
            <div class="group-last">
                <a href="{{route('client.customer.updateinfo')}}" class="updateinfo">Cập nhật tài khoản</a>
                <a href="{{route('changePassword')}}" class="changepassword">Đổi mật khẩu</a>
            </div>
        </div> -->
        <div class="content_page_double">
            <div class="box form"></div>
            <div class="box info">
                <div class="box_top">
                    <h5 class="title">Thông tin cá nhân</h5>
                    <a href="#"><i class="fas fa-user-edit"></i></a>
                </div>
                <div class="box_middle">
                    <ul>
                        <li>
                            <strong>Họ & Tên: </strong><span>{{Auth::user()->name}}</span>
                        </li>
                        <li>
                            <strong>Điện thoại: </strong><span>{{Auth::user()->phone}}</span>
                        </li>
                        <li>
                            <strong>Email: </strong><span>{{Auth::user()->email}}</span>
                        </li>
                    </ul>
                </div>
                <div class="box_bottom">
                    <a href="{{route('changePassword')}}" class="changepassword">Đổi mật khẩu</a>
                </div>
            </div>
            <div class="box">
                <div class="box_middle">
                    <ul>
                        <li>
                            <strong>Họ & Tên: </strong><span>{{Auth::user()->name}}</span>
                        </li>
                        <li>
                            <strong>Điện thoại: </strong><span>{{Auth::user()->phone}}</span>
                        </li>
                        <li>
                            <strong>Email: </strong><span>{{Auth::user()->email}}</span>
                        </li>
                    </ul>
                    <ul>
                        <li class="first_two">
                            <strong>Thú cưng đã mua: </strong>
                            @foreach($order as $or)
                                @foreach($orderDetail as $orD)
                                    @if($orD->order_id == $or->id && $or->delivery_status == 3 && $orD->product_type == 1)
                                        <a href="{{route('client.product.detail', ['id' => $orD->product->slug])}}">{{$orD->product->name}}</a><span class="rtrim">,</span>
                                    @endif
                                @endforeach
                            @endforeach
                        </li>
                        <li class="first_two">
                            <strong>Phụ kiện đã mua: </strong>
                            @foreach($order as $or)
                                @foreach($orderDetail as $orD)
                                @if($orD->order_id == $or->id && $or->delivery_status == 3 && $orD->product_type == 2)
                                        <a href="{{route('client.accessory.detail', ['id' => $orD->accessory->slug])}}">{{$orD->accessory->name}}</a><span class="rtrim">,</span>
                                    @endif
                                @endforeach
                            @endforeach
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <strong>Đơn hàng đang chờ xử lí:</strong>
                            <span>
                                <?php
                                    $totail = 0;
                                    foreach($order as $value){ if ($value->delivery_status == 1) { $totail +=1; } }
                                    echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng đang giao:</strong>
                            <span>
                                <?php
                                    $totail = 0;
                                    foreach($order as $value){ if ($value->delivery_status == 2) { $totail +=1; } }
                                    echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng giao thành công:</strong>
                            <span>
                                <?php
                                    $totail = 0;
                                    foreach($order as $value){ if ($value->delivery_status == 3) { $totail +=1; } }
                                    echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng bị hủy:</strong>
                            <span>
                                <?php
                                    $totail = 0;
                                    foreach($order as $value){ if ($value->delivery_status == 0) { $totail +=1; } }
                                    echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng đã hủy:</strong>
                            <span>
                                <?php
                                    $totail = 0;
                                    foreach($order as $value){ if ($value->delivery_status == 4) { $totail +=1; } }
                                    echo $totail;
                                ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
	<!-- content -->
@endsection