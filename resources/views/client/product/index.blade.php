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
            <div class="form-item">
                <label for="">Sắp xếp theo</label>
                <select name="" id="">
                    <option value="">Giá cao nhất</option>
                    <option value="">Giá thấp nhất</option>
                    <option value="">A-Z</option>
                    <option value="">Z-A</option>
                </select>
            </div>
            <div class="form-item">
                <label for="">Sắp xếp theo</label>
                <select name="" id="">
                    <option value="">Giá cao nhất</option>
                    <option value="">Giá thấp nhất</option>
                    <option value="">A-Z</option>
                    <option value="">Z-A</option>
                </select>
            </div>
        </form>
    </div>
    <div class="product-container">
        @foreach($product as $p)
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                    <!-- <p class="sale">
                        <span>Giảm: 155.000 vnd</span>
                    </p> -->
                </div>
                <div class="product-thumbnail">
                    <a href="{{route('product.client.detail', ['id' => $p->id])}}">
                        <img src="{{asset( 'storage/' . $p->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="product-extra">
                    <a href="#" class="fas fa-heart"></a>
                    <a href="#" class="fas fa-eye"></a>
                    <a href="#" class="fas fa-shopping-cart"></a>
                </div>
            </div>
            <div class="item-bottom">
                <div class="product-info">
                    <a href="#" class="name">{{$p->name}}</a>
                    <span class="category">Danh mục<a href="#" class="link-ct">{{$p->category->name}}</a></span>
                    <span class="price">{{number_format($p->price)}} VND</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <section class="paging">
    {{ $product->links('vendor.pagination.custom') }}
    </section>
</section>
	<!-- content -->
@endsection