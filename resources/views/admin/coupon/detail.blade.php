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
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Ảnh danh mục</label>
                                    <img class="form-control" style="width:100%; height: 100%" src="{{asset( 'storage/' . $category->image)}}" alt="Danh mục này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" class="form-control" value="{{$category->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Hiển thị slide</label>
                                    <input class="form-control" type="text" value="{{ ($category->show_slide == 1 ? 'Hiển thị' : 'Ẩn') }}" readonly>
                                </div>
                                <div class="row">
                                    <div class="col sm">
                                        <div class="form-group">
                                            <label for="">Số lượng sản phẩm</label>
                                            <input type="text" class="form-control" value="{{count($category->products)}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col sm">
                                        <div class="form-group">
                                            <label for="">Số lượng giống loài</label>
                                            <input type="text" class="form-control" value="{{count($category->breeds)}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <!-- <div class="row">
                                    <div class="col sm">
                                        <div class="form-group">
                                            <label for="">Số lượng sản phẩm</label>
                                            <input type="text" class="form-control" value="{{count($category->products)}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col sm">
                                        <div class="form-group">
                                            <label for="">Số lượng giống loài</label>
                                            <input type="text" class="form-control" value="{{count($category->breeds)}}" readonly>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-6 mt-2"><br>
                                <div class="text-right">
                                    <a href="{{route('category.index')}}" class="btn btn-warning text-light">Quay lại</a>
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