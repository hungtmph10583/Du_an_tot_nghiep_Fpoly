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
    <h2 class="heading">Giỏ hàng của tôi</h2>
    <!-- <div class="steps-to-take">
        <div class="step active" id="btn-cart">
            <i class="fas fa-shopping-cart"></i>
            <span>1. Giỏ hàng của tôi</span>
        </div>
        <div class="step" id="btn-address">
            <i class="fas fa-map-marked-alt"></i>
            <span>2. Địa chỉ nhận hàng</span>
        </div>
        <div class="step" id="btn-truck">
            <i class="fas fa-truck"></i>
            <span>3. Thông tin giao hàng</span>
        </div>
        <div class="step" id="btn-pay">
            <i class="fas fa-credit-card"></i>
            <span>4. Thanh toán</span>
        </div>
        <div class="step" id="btn-bill">
            <i class="far fa-check-circle"></i>
            <span>5. Xác nhận</span>
        </div>
    </div> -->
    <div class="cart-detail-container">
        <div class="carts active">
            <div class="carts-container">
                <?php
                    $content = Cart::content();
                    $count = Cart::content()->count();
                    // echo '<pre>';
                    // print_r($count);
                    // echo '</pre>';
                ?>
                @if(empty($count))
                <div class="alert">
                    <p>
                        Hiện không có sản phẩm trong giỏ hàng
                        <span>
                            <a href="{{route('client.product.index')}}">
                                <i class="fas fa-arrow-left"></i> 
                                Quay lại trang sản phẩm</a>
                        </span>
                    </p>
                </div>
                @endif
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
                            <form action="{{route('updateCartQty', ['rowId' => $value->rowId])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                                Số lượng: <input type="number" value="{{$value->qty}}" name="quantity_cart" max="{{$value->quantity}}" min="1">
                                <input type="hidden" value="{{$value->rowId}}" name="rowId_cart">
                                <input type="submit" value="Cập nhật" name="update_qty" class="updateQty">
                            </form>
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
                    <div class="delete-product">
                        <a href="{{route('deleteToCart', ['rowId' => $value->rowId])}}">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @if(!empty($count))
        <div class="group-double">
            <div class=""></div>
            <div class="group-item">
                <div class="pay-second">
                    <div class="cart-detail-heading">
                        <span>Tóm tắt</span>
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
                            <span class="both">
                                {{Cart::priceTotal(0,',','.')}}đ
                            </span>
                        </div>
                        <div class="item">
                            <span class="both">Thuế</span>
                            <span class="both">
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
                        </div>
                    </div>
                    <div class="item-last">
                        <button class="btn-pay" id="cart-next">
                            <a href="{{route('checkout')}}">Thanh toán</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
