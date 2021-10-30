@extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('blog.index')}}">Danh sách bài viết</a></li>
                    <li class="breadcrumb-item active">Tạo bài viết</li>
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
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tiêu đề bài viết</label>
                                <input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="Tiêu đề bài viết"> @error('title')
                                <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Danh mục bài viết</label>
                                <select class="form-control" name="category_id" id="">
                                    <option value="">Chó</option>
                                    <option value="">Mèo</option>
                                    <option value="">Rùa</option>
                                    <option value="">Khỉ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ảnh bìa</label>
                                <input type="file" name="uploadfile" class="form-control"> @error('uploadfile')
                                <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-control">
                                    <label class="pr-2">
                                        <input type="radio" name="status" value="1" checked> Hiển thị
                                    </label>
                                    <label class="pl-2">
                                        <input type="radio" name="status" value="0"> Ẩn bài viết
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nội dung bài viết</label>
                                <textarea class="form-control" name="content" id="" cols="30" rows="10" placeholder="Nội dung bài viết"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('blog.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection