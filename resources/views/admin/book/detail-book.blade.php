@section('title', 'Chi tiết sách')
@extends('layouts.admin.main')
@section('content')
<main class="container-fluid" style="height: auto;">
    <div class="container">
        <div class="sp" style="display: grid;
    grid-template-columns: 1fr 1fr;">
            <div class=" image">
                <img width="300" src="{{asset('storage/'.$detail->image)}}" alt="">
            </div>
            <div class="info">
                <h2>Tên sản phẩm : {{$detail->name}}</h2>
                <p>Giá : {{number_format($detail->price) . " " . 'VNĐ'}}</p>
                <p>Tên loại : {{$detail->categories->name}}</p>
                <p>Trạng thái : @if($detail->status == 1)
                    Còn hàng
                    @else
                    Hết
                    @endif
                </p>
                <p>số lượng : {{$detail->quantity}}</p>
                <p>
                    @isset($detail->authors)
                    Tác giả :
                    @foreach($detail->authors as $t)
                    <span style="border: solid 1px #ccc; margin-right: 5px;">{{$t->name}}</span>
                    @endforeach
                    @endisset
                </p>
                <p>
                    @isset($detail->genres)
                    Thể loại :
                    @foreach($detail->genres as $t)
                    <span style="border: solid 1px #ccc; margin-right: 5px;">{{$t->name}}</span>
                    @endforeach
                    @endisset
                </p>
                <p>
                    @isset($detail->galleries)
                    Gallery :
                    @foreach($detail->galleries as $gale)
                    <img width="70" src="{{asset('storage/'.$gale->url)}}" alt="">
                    @endforeach
                    @endisset
                </p>
                <p>Chi tiết sản phẩm : {!! $detail->detail !!}</p>
            </div>
        </div>
    </div>
</main>
@endsection