@section('title', 'Lịch sử mua hàng')
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
                    <a href="{{route('client.customer.info')}}">
                        <i class="fas fa-user"></i>
                        Thông tin tài khoản
                    </a>
                </li>
                <li>
                    <a href="{{route('client.customer.orderHistory')}}" class="active">
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
            <div class="title">Đơn hàng của tôi</div>
            <table class="greenTable">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Sản phẩm</th>
                        <th>Ngày mua</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái đơn hàng</th>
                    </tr>
                </thead>
                <tbody class="list-overflow">
                    @foreach($orderDetail as $orD)
                        @foreach($order as $or)
                            @if($or->id == $orD->order_id)
                            <tr>
                                <td>{{$orD->order->code}}</td>
                                <td>
                                    <a href="{{route('client.product.detail', ['id' => $orD->product->id])}}">
                                        <img src="{{asset( 'storage/' . $orD->product->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" width="100">
                                    </a>
                                </td>
                                <td>{{date_format($orD->order->created_at,"d/m/Y H:i:s")}}</td>
                                <td>{{number_format($orD->order->grand_total,0,',','.')}}đ</td>
                                <td>
                                    @if($orD->order->delivery_status == 1)
                                        Đang chờ xử lý
                                    @elseif($orD->order->delivery_status == 2)
                                        Đang giao hàng
                                    @elseif($orD->order->delivery_status == 3)
                                        Giao hàng thành công
                                    @elseif($orD->order->delivery_status == 0)
                                        Hủy đơn hàng
                                    @else
                                        Lỗi code
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
	<!-- content -->
@endsection
