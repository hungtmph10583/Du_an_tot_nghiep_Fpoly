@extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('category.index')}}">Danh sách danh mục</a></li>
                    <li class="breadcrumb-item active">Sửa danh mục</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Ảnh danh mục</label>
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}" alt="Danh mục này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tên danh mục</label>
                                <input type="text" name="name" class="form-control" value="{{$model->name}}" placeholder="Tên danh mục">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Ảnh danh mục</label>
                                <input type="file" name="uploadfile" class="form-control"> @error('uploadfile')
                                <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Loại danh mục</label>
                                <select name="category_type_id" class="form-control">
                                @foreach($categoryType as $type)
                                    <option value="{{$type->id}}" @if($model->category_type_id == $type->id) selected @endif>{{$type->name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <label for="">Hiển thị ra slide</label>
                                        <div class="form-control">
                                            <label class="pr-2">
                                            <input type="radio" name="show_slide" value="1" {{ ($model->show_slide == 1 ? 'checked' : '') }}> Hiển thị
                                        </label>
                                                <label class="pl-2">
                                            <input type="radio" name="show_slide" value="0" {{ ($model->show_slide == 0 ? 'checked' : '') }}> Ẩn
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('category.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection