@section('title', 'Danh sách tài khoản')
@extends('layouts.admin.main')
@section('content')

<div class="row">
    <div class="col-6">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Tên Sản Phẩm</label>
                <input type="text" name="name" value="{{old('name', $cate->name)}}" class="form-control">
            </div>
            @error('name')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <div class="form-group">
                <label for="">Trạng thái</label>
                <select class="custom-select" name="status" id="status">
                    <option value="">Chọn trạng thái</option>
                    <option {{ ($cate->status == 0) ? 'selected="selected"' : '' }} value="0">Không hoạt động</option>
                    <option {{ ($cate->status == 1) ? 'selected="selected"' : '' }} value="1">Hoạt động</option>
                </select>
                
            </div>
            <div class="form-group">
                <label for="">Show Menu</label>
                <select class="custom-select" name="show_menu" id="show_menu">
                    <option value="">Chọn show_menu</option>
                    <option {{ ($cate->show_menu == 0) ? 'selected="selected"' : '' }} value="0">Không hoạt động</option>
                    <option {{ ($cate->show_menu == 1) ? 'selected="selected"' : '' }} value="1">Hoạt động</option>
                </select>
                
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>


@endsection