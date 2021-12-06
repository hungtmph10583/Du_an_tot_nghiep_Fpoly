@section('title', 'Sản phẩm')
@extends('layouts.client.main')
@section('content')
<!-- content -->
<!-- section product -->
<section class="products">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Thú cưng</span>
    </div>
    <h1 id="heading">Thú cưng</h1>
    <div class="product-top">
        <form action="">
            <div class="double">
                <div class="form-item">
                    <!-- <label for="">Danh mục</label> -->
                    <select name="" id="">
                        <option value="">Tìm kiếm theo danh mục</option>
                        @foreach($category as $cate)
                            @if($cate->category_type_id == 1)
                            <option value="{{$cate->id}}">{{$cate->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-item">
                    <!-- <label for="">Sắp xếp theo</label> -->
                    <select name="" id="">
                        <option value="">Thứ tự mặc định</option>
                        <option value="">Giá cao nhất</option>
                        <option value="">Giá thấp nhất</option>
                        <option value="">Mua nhiều nhất</option>
                        <option value="">Hàng mới</option>
                    </select>
                </div>
            </div>
            <div class="clear-both"></div>
            <button>Search</button>
            <div class="clear-both"></div>
        </form>
    </div>
    <div class="product-container">
        @foreach($product as $p)
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                </div>
                <div class="product-thumbnail">
                    <a href="{{route('client.product.detail', ['id' => $p->slug])}}">
                        <img src="{{asset( 'storage/' . $p->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="product-extra">
                    <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="product_id_hidden" value="{{$p->id}}">
                            <input type="hidden" name="product_type" value="1">
                            <input type="hidden" name="discount_price" value="{{$p->discount}}">
                            <input type="hidden" name="category_id" value="{{$p->category_id}}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-buyNow">Thêm vào giỏ hàng</button>
                        </form>
                </div>
            </div>
            <div class="item-bottom">
                <div class="product-info">
                    <a href="{{route('client.product.detail', ['id' => $p->slug])}}" class="name">{{$p->name}}</a>
                    @if($p->discount == '')
                        <span class="price">{{number_format($p->price)}}đ</span>
                    @else
                        <span class="discount">{{number_format($p->price)}}đ</span><br>
                        <span class="price">
                            <?php
                                echo number_format($p->price - $p->discount).'đ';
                            ?>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="paging">
    {{ $product->links('vendor.pagination.custom') }}
    </div>
</section>
	<!-- content -->
@endsection
