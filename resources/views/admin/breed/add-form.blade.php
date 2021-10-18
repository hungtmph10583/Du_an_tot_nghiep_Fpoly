@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('breed.index')}}">Danh sách giống loài</a></li>
                        <li class="breadcrumb-item active">Tạo giống loài</li>
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
                            <div class="col sm">
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
                            </div>
                            <div class="col sm">
                                <div class="form-group">
                                    <label for="">Tên giống loài</label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Tên giống loài">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col sm">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Trạng thái</label>
                                            <div class="form-control">
                                                <label class="pr-2">
                                                    <input type="radio" name="status" value="1" checked> Hiển thị
                                                </label>
                                                <label class="pl-2">
                                                    <input type="radio" name="status" value="0"> Ẩn
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm">
                                <div class="form-group">
                                    <label for="">Ảnh</label>
                                    <div class="form-control">
                                        <input type="file" name="uploadfile" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="col sm mt-2"><br>
                                <div class="text-left">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <a href="{{route('breed.index')}}" class="btn btn-danger">Hủy</a>
                                </div>
                            </div>
                            <div class="col sm"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection