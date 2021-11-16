@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-light my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('slide.index')}}">Danh sách Slide</a></li>
                    <li class="breadcrumb-item active">Thêm slide</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $slide->image)}}" alt="slide này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ảnh slide</label>
                                <input type="file" name="uploadfile" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="1" @if($slide->status == 1) selected @endif>Hiển thị</option>
                                    <option value="0" @if($slide->status == 0) selected @endif>Không</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info ml-2">Lưu</button>
                                <a href="{{route('slide.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection