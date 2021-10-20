@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('breed.index')}}">Danh sách giống loài</a></li>
                        <li class="breadcrumb-item active">Sửa giống loài</li>
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
                                    <label for="">Ảnh đại diện giống loài</label>
                                    <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}" alt="Giống loài này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="">Tên giống loài</label>
                                    <input type="text" name="name" class="form-control" value="{{$model->name}}" placeholder="Tên giống loài" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <input class="form-control" type="text" value="{{$model->category->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Số lượng sản phẩm</label>
                                    <input type="text" class="form-control" value="{{count($model->products)}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <input class="form-control" type="text" value="{{ ($model->status == 1 ? 'Active' : 'Inactive') }}" readonly>
                                </div><br>
                                <div class="text-left">
                                    <a href="{{route('breed.index')}}" class="btn btn-warning text-light">Quay lại</a>
                                    <a href="{{route('breed.edit', ['id' => $model->id])}}" class="btn btn-info">Sửa giống loài</a>
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