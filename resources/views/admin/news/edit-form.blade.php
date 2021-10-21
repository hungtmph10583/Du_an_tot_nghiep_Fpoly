@extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('category.index')}}">Danh sách tin tức</a></li>
                    <li class="breadcrumb-item active">Sửa tin tức</li>
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
                                <label for="">Ảnh tin tức</label>
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}" alt="Tin tức này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tiêu đề tin tức</label>
                                <input type="text" name="title" class="form-control" value="{{$model->title}}" placeholder="Tiêu đề tin tức">
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Ảnh tin tức</label>
                                <input type="file" name="uploadfile" class="form-control"> @error('uploadfile')
                                <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Trạng thái</label>
                                        <div class="form-control">
                                            <label class="pr-2">
                                        <input type="radio" name="status" value="1" {{ ($model->status == 1 ? 'checked' : '') }}> Hiển thị
                                    </label>
                                            <label class="pl-2">
                                        <input type="radio" name="status" value="0" {{ ($model->status == 0 ? 'checked' : '') }}> Ẩn
                                    </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nội dung bài viết</label>
                                <textarea class="form-control" name="content" id="" cols="30" rows="10" placeholder="{{$model->content}}">{{$model->content}}</textarea>
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