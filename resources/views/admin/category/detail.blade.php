@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('category.index')}}">Danh sách danh mục</a></li>
                        <li class="breadcrumb-item active">Chi tiết danh mục</li>
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
                                    <input type="text" class="form-control" value="{{$category->name}}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Trạng thái</label>
                                            <div class="form-control">
                                                <label class="pr-2">
                                                    <input type="radio" {{ ($category->status == 1 ? 'checked' : '') }} readonly> Hiển thị
                                                </label>
                                                <label class="pl-2">
                                                    <input type="radio" {{ ($category->status == 0 ? 'checked' : '') }} readonly> Ẩn
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Show menu</label>
                                            <div class="form-control">
                                                <label class="pr-2">
                                                    <input type="radio" name="show_menu" value="1"  {{ ($category->show_menu == 1 ? 'checked' : '') }}> Hiển thị
                                                </label>
                                                <label class="pl-2">
                                                    <input type="radio" name="show_menu" value="0" {{ ($category->show_menu == 0 ? 'checked' : '') }}> Ẩn
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col sm">
                                        <div class="form-group">
                                            <label for="">Số lượng sản phẩm</label>
                                            <input type="text" class="form-control" value="{{count($category->products)}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col sm">
                                        <div class="form-group">
                                            <label for="">Số lượng giống loại</label>
                                            <input type="text" class="form-control" value="{{count($category->breeds)}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mt-2"><br>
                                <div class="text-left">
                                    <a href="{{route('category.index')}}" class="btn btn-warning">Quay lại</a>
                                    <a href="{{route('category.edit', ['id' => $category->id])}}" class="btn btn-info">Sửa danh mục</a>
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