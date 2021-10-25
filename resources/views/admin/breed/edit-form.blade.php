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
                                    <input type="text" name="name" class="form-control" value="{{$model->name}}" placeholder="Tên giống loài">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        @foreach($category as $c)
                                            @if($c->genre_type == 0)
                                            <option value="{{$c->id}}" @if($c->id == old('category_id')) selected @endif>{{$c->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh</label>
                                    <div class="form-control">
                                        <input type="file" name="uploadfile" id="">
                                    </div>
                                </div>
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
                                </div><br>
                                <div class="text-left">
                                    <button type="submit" class="btn btn-info">Lưu</button>
                                    <a href="{{route('breed.index')}}" class="btn btn-danger">Hủy</a>
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