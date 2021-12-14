@section('title', 'Giỏ hàng')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/gio-hang.css')}}">
@endsection
<!-- content -->
<section class="cart-details">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Giỏ hàng</span>
    </div>
    <h2 class="heading">Giỏ hàng của tôi</h2>
    <div class="cart-detail-container">
        <div class="carts">
            <div class="carts-container">
                <?php
                $content = Cart::content();
                $count = Cart::content()->count();
                // echo '<pre>';
                // print_r($content);
                // echo '</pre>';
                ?>
                @if(empty($count))
                <div class="empty_cart">
                    <div class="image_cart_none">
                        <img src="{{ asset('client-theme/images/emptycart.gif')}}" alt="">
                    </div>
                    <div class="text-alert">
                        <p>Giỏ hàng trống</p>
                        <p>Vui lòng thêm sản phẩm vào để tiếp tục mua hàng</p>
                    </div>
                    <div class="redirect">
                        <a href="{{route('client.product.index')}}">
                            <i class="fas fa-chevron-left"></i>
                            <span>Vào trang sản phẩm</span>
                        </a>
                        <a href="{{route('client.product.index')}}">
                            <i class="fas fa-home"></i>
                            <span>Quay về trang chủ</span>
                        </a>
                    </div>
                </div>
                @endif
                @foreach($content as $value)
                <div class="cart-item">
                    <div class="product-thumbnail">
                        @if($value->weight == 1)
                        <a href="javascript:;">
                            <img src="{{asset( 'storage/' . $value->options->image)}}" alt="">
                        </a>
                        @elseif($value->weight == 2)
                        <a href="javascript:;">
                            <img src="{{asset( 'storage/' . $value->options->image)}}" alt="">
                        </a>
                        @endif
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
                            <form action="{{route('updateCartQty', ['rowId' => $value->rowId])}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                Số lượng:
                                @if($value->weight == 1)
                                    @foreach($product as $pro)
                                        @if($pro->id == $value->id)
                                        <input type="number" value="{{$value->qty}}" name="quantity_cart" max="{{$pro->quantity}}" min="1">
                                        @endif
                                    @endforeach
                                @elseif($value->weight == 2)
                                    @foreach($accessory as $acs)
                                        @if($acs->id == $value->id)
                                        <input type="number" value="{{$value->qty}}" name="quantity_cart" max="{{$acs->quantity}}" min="1">
                                        @endif
                                    @endforeach
                                @else
                                error
                                @endif
                                <input type="hidden" value="{{$value->rowId}}" name="rowId_cart">
                                <input type="submit" value="Cập nhật" name="update_qty" class="updateQty">
                            </form>
                        </div>
                        <div class="total">
                            Tổng: <span>
                                <?php
                                $subtotal = $value->price * $value->qty;
                                echo number_format($subtotal, 0, ',', '.');
                                ?>
                                đ
                            </span>
                        </div>
                    </div>
                    <div class="delete-product">
                        <a onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')"
                            href="{{route('deleteToCart', ['rowId' => $value->rowId])}}">
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
                                echo number_format($subtotal, 0, ',', '.');
                                ?>
                                đ
                            </span>
                        </div>
                        @endforeach
                        <!-- (E) vòng lặp sp -->
                        <div class="item">
                            <span class="both">Tạm tính</span>
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