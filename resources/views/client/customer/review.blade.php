@section('title', 'Đánh giá của tôi')
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
                    <a href="{{route('client.customer.review')}}" class="active">
                        <i class="fas fa-star-half-alt"></i>
                        Nhận xét của tôi
                    </a>
                </li>
            </ul>
        </div>
        <div class="account-info-right">
            <div class="title">Đánh giá sản phẩm</div>
            <table class="greenTable">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Xếp hạng sp</th>
                        <th>Nội dung đánh giá</th>
                        <th>Thời gian</th>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody class="list-overflow">
                    @foreach($review as $rv)
                        @foreach($product as $pro)
                            @if($rv->product_id == $pro->id)
                            <tr>
                                <td>
                                    <a href="{{route('client.product.detail', ['id' => $rv->product->id])}}">
                                        <img src="{{asset( 'storage/' . $rv->product->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" width="100">
                                    </a>
                                </td>
                                <td>
                                    <span class="star">
                                       @for($count=1; $count<=5; $count++)
                                            @if($count <= $pro->reviews->rating)
                                                <i class="fas fa-star rating"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                </td>
                                <td class="comment">{{$rv->comment}}</td>
                                <td>{{date_format($rv->created_at,"d/m/Y H:i:s")}}</td>
                                <td>
                                    <a href="#" class="edit-review">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{route('deleteReview', ['id' => $rv->id])}}" onclick="return confirm('Bạn có chắc muốn xóa review này?')" class="delete-review">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
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
