@section('title', 'Giỏ hàng')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/gio-hang.css')}}">
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
<section class="cart-details">
    <h2 class="heading">Thanh toán</h2>
    <div class="cart-detail-container">
        <div class="carts active">
            <div class="carts-container">
                <?php
                    $content = Cart::content();
                ?>
                @foreach($content as $value)
                <div class="cart-item">
                    <div class="product-thumbnail">
                        <a href="#">
                            <img src="{{asset( 'storage/' . $value->options->image)}}" alt="">
                        </a>
                    </div>
                    <div class="product-info">
                        <h5 class="name">{{$value->name}}</h5>
                        <!-- <div class="category">
                            Danh mục: <span>Bird</span>
                        </div> -->
                        <div class="price">
                            Giá tiền: <span>{{number_format($value->price,0,',','.')}}đ</span>
                        </div>
                        <div class="quantity">
                            Số lượng: <span>{{$value->qty}}</span>
                        </div>
                        <div class="total">
                            Tổng: <span>
                                <?php
                                    $subtotal = $value->price * $value->qty;
                                    echo number_format($subtotal,0,',','.');
                                ?>
                                đ
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="group-double">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="group-item">
                    <div class="cart-detail-heading">
                        <span>Thông tin liên lạc</span>
                    </div>
                    <div class="form-group">
                        @if(Auth::check())
                            <input type="text" name="phone" placeholder="Số điện thoại" value="{{Auth::user()->phone}}">
                        @else
                            <input type="text" name="phone" placeholder="Số điện thoại" value="{{old('phone')}}">
                        @endif
                        @error('phone')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        @if(Auth::check())
                            <input type="text" name="email" placeholder="Email" value="{{Auth::user()->email}}">
                        @else
                            <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
                        @endif
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="cart-detail-heading">
                        <span>Địa chỉ giao hàng</span>
                    </div>
                    <div class="form-group-double">
                        @if(Auth::check())
                            <input type="text" placeholder="Họ & Tên" name="name" value="{{Auth::user()->name}}">
                        @else
                            <input type="text" placeholder="Họ & Tên" name="name" value="{{old('name')}}">
                        @endif
                    </div>
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <input type="text" placeholder="Thành phố: (Hà Nội)" name="city" value="Hà Nội">
                    </div>
                    @error('city')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group-double">
                        <input type="text" placeholder="Quận huyện (Nam Từ Liêm)" name="district" value="Nam Từ Liêm">
                        <input type="text" placeholder="Phường xã (Cầu Diễn)" name="ward" value="Cầu Diễn">
                    </div>
                    <div class="form-group-double">
                        @error('district')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        @error('ward')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Địa chỉ nhà (196 Hồ Tùng Mậu)" name="address" value="196 Hồ Tùng Mậu">
                    </div>
                    @error('address')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="cart-detail-heading">
                        <span>Ghi chú khi giao hàng</span>
                    </div>
                    <div class="form-group">
                        <textarea name="note" id="" cols="30" rows="10" placeholder="Ghi chú"></textarea>
                    </div>
                    <div class="cart-detail-heading">
                        <span>Hình thức thanh toán</span>
                    </div>
                    <div class="form-group-type-payment">
                        <input type="radio" name="ptvc" id="ptvc" value="1" checked><label for="ptvc">Thanh toán khi giao hàng</label>
                    </div>
                </div>
                <div class="group-item">
                    <div class="pay-second">
                        <div class="cart-detail-heading">
                            <span>Đơn hàng của bạn</span>
                        </div>
                        <div class="pay-second-container">
                            <div class="item">
                                <span class="both">Sản phẩm</span>
                                <span class="both">Tổng tiền</span>
                            </div>
                            <!-- (S) vòng lặp sp -->
                            @foreach($content as $value)
                            <div class="item">
                                <span>{{$value->name}}</span>
                                <span>
                                    <?php
                                        $subtotal = $value->price * $value->qty;
                                        echo number_format($subtotal,0,',','.');
                                    ?>
                                    đ
                                </span>
                            </div>
                            @endforeach
                            <!-- (E) vòng lặp sp -->
                            <div class="item">
                                <span class="both">Tổng thanh toán</span>
                                <span class="both" name="priceTotal">
                                    {{Cart::priceTotal(0,',','.')}}đ
                                </span>
                            </div>
                            <div class="item">
                                <span class="both">Thuế</span>
                                <span class="both">
                                    <input type="hidden" value="{{Cart::tax(0,',','')}}" name="tax">
                                    {{Cart::tax(0,',','.')}}đ
                                </span>
                            </div>
                            <div class="item">
                                <span class="both">Chi phí vận chuyển</span>
                                <span class="both">Free</span>
                            </div>
                            <div class="item">
                                <span class="both">Tổng tiền</span>
                                <span class="both total">
                                    {{Cart::total(0,',','.')}}đ
                                </span>
                                <input type="hidden" value="{{Cart::total(0,',','')}}" name="grand_total">
                            </div>
                        </div>
                        <div class="item-last">
                            <button class="btn-pay" type="submit" id="cart-next"><span>Thanh toán</span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- <div class="group-double">
            <div class="group-item">
                
            </div>
            <div class="group-item"></div>
        </div> -->
    </div>
</section>
@endsection