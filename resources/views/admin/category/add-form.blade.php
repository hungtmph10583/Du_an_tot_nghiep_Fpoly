@section('title', 'Danh sách tài khoản')
@extends('layouts.admin.main')
@section('content')


@php
$statusList = [
    [
    'id' => 0,
    "name" => "Không hoạt động"
    ],
    [
    'id' => 1,
    "name" => "Hoạt động"
    ],
];
$show_menuList = [
    [
    'id' => 0,
    "name" => "Không hoạt động"
    ],
    [
    'id' => 1,
    "name" => "Hoạt động"
    ],
];
@endphp
<div class="row">
    <div class="col-6">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Tên Sản Phẩm</label>
                <input type="text" name="name" class="form-control">
            </div>
            @error('name')
            <p class="text-danger">{{$message}}</p>
            @enderror
            <div>
            <label for="">Trạng thái:</label>
            <br>
            @foreach ($statusList as $item)
                <input type="radio" name="status" value="{{$item['id']}}" 
                    @if($loop->index == 0) checked @endif> {{$item['name']}}
            @endforeach
            </div>
            <div>
            <label for="">Show_menu:</label>
            <br>
            @foreach ($show_menuList as $item)
                <input type="radio" name="show_menu" value="{{$item['id']}}" 
                    @if($loop->index == 0) checked @endif> {{$item['name']}}
            @endforeach
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

@endsection