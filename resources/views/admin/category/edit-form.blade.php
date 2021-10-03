@extends('layouts.admin.main')
@section('content')
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
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" name="name" class="form-control" value="{{$model->name}}" placeholder="Tên danh mục">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Trạng thái</label>
                                            <div class="mt-2">
                                                <label class="pr-2">
                                                <input type="radio" name="status" value="1" {{ ($model->status == 1 ? 'checked' : '') }}> Hiển thị
                                            </label>
                                            <label class="pl-2">
                                                <input type="radio" name="status" value="0" {{ ($model->status == 0 ? 'checked' : '') }}> Ẩn
                                            </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Show menu</label>
                                            <div class="mt-2">
                                                <label class="pr-2">
                                                    <input type="radio" name="show_menu" value="1"  {{ ($model->show_menu == 1 ? 'checked' : '') }}> Hiển thị
                                                </label>
                                                <label class="pl-2">
                                                    <input type="radio" name="show_menu" value="0" {{ ($model->show_menu == 0 ? 'checked' : '') }}> Ẩn
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-6">
                                <div class="form-group">
                                    <label for="">Loại danh mục</label>
                                    <select name="genre_type" class="form-control">
                                        <option value="0" @if($model->genre_type === 0) selected @endif>Thú cưng</option>
                                        <option value="1" @if($model->genre_type === 1) selected @endif>Phụ kiện</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 mt-2"><br>
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <a href="{{route('category.index')}}" class="btn btn-danger">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <br>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection