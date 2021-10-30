@extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('blogCategory.index')}}">Danh sách danh mục bài viết</a></li>
                    <li class="breadcrumb-item active">Tạo danh mục bài viết</li>
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
                                <label for="">Tên danh mục bài viết</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Tiêu đề danh mục bài viết"> @error('name')
                                <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="col-6 mt-2"><br>
                            <div class="float-left">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('blogCategory.index')}}" class="btn btn-danger">Hủy</a>
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