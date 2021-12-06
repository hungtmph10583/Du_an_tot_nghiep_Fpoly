@extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Cài đặt hiển thị Footer</li>
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
                    <div class="card-title">Row 1</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nội dung</label>
                                <input type="text" class="form-control" placeholder="Nội dung hiển thị">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Đường dẫn</label>
                                <input type="text" class="form-control" placeholder="Đường dẫn liên kết trang">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Kiểu hiển thị</label>
                                <select name="type" id="" class="form-control">
                                    <option value="">Tĩnh</option>
                                    <option value="">Liên kết đường dẫn</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('dashboard.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection