@section('title', 'Sản phẩm')
@extends('layouts.client.main')
@section('content')
	<!-- content -->
<div class="section-mt"></div>
<section class="search">
    <div class="container">
        <form action="" class="search-form">
            <div class="form-field">
                <input type="search" class="form-input" id="search-box" placeholder=" ">
                <label for="search" class="form-label"><i class="fas fa-search"></i> search here...</label>
            </div>
            <!-- <button for="search-box">
                <i class="fas fa-search"></i>
            </button> -->
        </form>
    </div>
</section>
<!-- section product -->
<section class="products">
    <div class="product-top">
        <form action="">
            <div class="double">
                <div class="form-item">
                    <label for="">Danh mục</label>
                    <select name="" id="">
                        <option value="">Tìm kiếm theo danh mục</option>
                        @foreach($category as $cate)
                        <option value="{{$cate->id}}">{{$cate->name}}t</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-item">
                    <label for="">Sắp xếp theo</label>
                    <select name="" id="">
                        <option value="">Giá cao nhất</option>
                        <option value="">Giá thấp nhất</option>
                        <option value="">Bán chạy nhất</option>
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
                    <a href="{{route('client.product.detail', ['id' => $p->id])}}">
                        <img src="{{asset( 'storage/' . $p->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="product-extra">
                    <form action="{{route('buyNow')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="product_id_hidden" value="{{$p->id}}">
                        <input type="hidden" name="discount_price" value="{{$p->discount}}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-buyNow">Mua hàng</button>
                    </form>
                </div>
            </div>
            <div class="item-bottom">
                <div class="product-info">
                    <a href="{{route('client.product.detail', ['id' => $p->id])}}" class="name">{{$p->name}}</a>
                    @if($p->discount == '')
                        <span class="price">{{number_format($p->price)}}đ</span>
                    @else
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