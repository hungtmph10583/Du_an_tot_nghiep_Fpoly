@section('title', 'Phụ kiện')
@extends('layouts.client.main')
@section('content')
<!-- content -->
<!-- section product -->
<section class="products">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Phụ kiện</span>
    </div>
    <h1 id="heading">Phụ kiện</h1>
    <div class="product-top">
        <form action="">
            <div class="double">
                <div class="form-item">
                    <!-- <label for="">Danh mục</label> -->
                    <select name="cate_id" id="">
                        <option value="">Tất cả danh mục</option>
                        @foreach($category as $cate)
                            @if($cate->category_type_id == 2)
                            <option @if(isset($searchData['cate_id']) &&  $searchData['cate_id'] == $cate->id) selected @endif value="{{$cate->id}}">{{$cate->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-item">
                    <!-- <label for="">Sắp xếp theo</label> -->
                    <select name="order_by" id="">
                        <option value="0">Mặc định</option>
                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 1) selected @endif value="1">Giá tăng dần</option>
                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 2) selected @endif value="2">Giá giảm dần</option>
                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 3) selected @endif value="3">Sản phẩm mới nhất</option>
                    </select>
                </div>
            </div>
            <div class="clear-both"></div>
            <button>Search</button>
            <div class="clear-both"></div>
        </form>
    </div>
    <div class="product-container">
        @foreach($accessory as $p)
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                </div>
                <div class="product-thumbnail">
                    <a href="{{route('client.accessory.detail', ['id' => $p->slug])}}">
                        <img src="{{asset( 'storage/' . $p->image)}}" alt="Phụ kiện này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="product-extra">
                    <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="product_id_hidden" value="{{$p->id}}">
                        <input type="hidden" name="product_type" value="2">
                        <input type="hidden" name="discount_price" value="{{$p->discount}}">
                        <input type="hidden" name="category_id" value="{{$p->category_id}}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-buyNow">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
            <div class="item-bottom">
                <div class="product-info">
                    <a href="{{route('client.accessory.detail', ['id' => $p->slug])}}" class="name">{{$p->name}}</a>
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
        @if(empty(count($accessory)))
            <div class="empty_product">
                <span>Danh mục này chưa có sản phẩm!</span>
            </div>
        @endif
    <div class="paging">
    {{ $accessory->links('vendor.pagination.custom') }}
    </div>
</section>
	<!-- content -->
@endsection
