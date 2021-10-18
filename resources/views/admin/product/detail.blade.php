@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('product.index')}}">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active">Sửa sản phẩm</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" value="{{$model->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <input type="text" name="category_id" class="form-control" value="{{$model->category->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Giống loài</label>
                                    <input type="text" name="breed_id" class="form-control" value="{{$model->breed->name}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="text" name="quantity" class="form-control" value="{{$model->quantity}}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Cân nặng</label>
                                    <input type="text" name="weight" class="form-control" value="{{$model->weight}} kg" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"> 
                                <div class="form-group">
                                    <label for="">Giá bán</label>
                                    <input type="text" name="price" class="form-control" value="{{$model->price}}" readonly>
                                </div>
                            </div>
                            <div class="col-6"> 
                                <div class="form-group">
                                    <label for="">Tuổi của thú cưng</label>
                                    <input type="text" name="age_id" class="form-control" value="{{$model->age_id}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <input class="form-control" type="text" name="status" value="{{ ($model->status == 1 ? 'Còn Hàng' : 'Hết hàng') }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Giới tính</label>
                                        <input class="form-control" type="text" name="gender_id" value="{{ ($model->gender_id == 1 ? 'Giống đực' : ($model->gender_id == 2 ? 'Giống cái' : 'Lưỡng tính')) }}"readonly >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Chi tiết sản phẩm:</label>
                                    <textarea name="detail" class=form-control rows="10" readonly>{{$model->detail}}</textarea>
                                </div>
                            </div>
                            <div class="text-left">
                                    <a href="{{route('product.index')}}" class="btn btn-warning text-light">Quay lại</a>
                                    <a href="{{route('product.edit', ['id' => $model->id])}}" class="btn btn-info">Sửa danh mục</a>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('pagejs')

@endsection