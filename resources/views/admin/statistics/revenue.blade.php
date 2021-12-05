@section('title', 'Thống kê doanh thu')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Thống kê doanh thu</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <div class="card">
            <div class="card-body table-responsive pad">
                @if(session('success') != null || session('danger') != null)
                <div class="alert @if (session('success')) alert-success @else alert-danger @endif alert-dismissible fade show" role="alert">
                    <strong>@if (session('success')) Success @else Error @endif</strong> {{session('success') }} {{ session('danger') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <form action="" method="get">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Sắp xếp theo</label>
                                <select class="form-control" name="order_by" >
                                    <option value="">Mặc định</option>
                                    <option value="1">Tháng</option>
                                    <option value="2">Đơn đang giao hàng</option>
                                    <option value="3">Đơn giao thành công</option>
                                    <option value="0">Đơn hàng đã huỷ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info mt-2">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Thời gian</th>
                            <!-- <th>Tổng tiền</th> -->
                            <th>Trạng thái</th>
                            <th class="text-center">Thanh toán</th>
                            <th><span class="float-right mr-4">Lựa chọn</span></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection