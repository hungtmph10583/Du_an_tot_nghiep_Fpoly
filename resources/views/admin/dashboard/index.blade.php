@section('title', 'Dashboard')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Dashboard</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            {{$countOrderDelivery}}
                        </h3>
                        <p>Đơn hàng đang chờ xử lý</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            <?php
                            foreach ($order as $value) {
                                echo number_format($value, 0, ',', '.') . 'đ';
                            }
                            ?>
                        </h3>
                        <p>Doanh thu tháng</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-money-bill-alt"></i>
                    </div>
                    <a href="#" class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$review}}</h3>
                        <p>Đánh giá</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sản phẩm thú cưng bán chạy tháng này
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Người mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataPet as $key => $sell)
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>
                                        @foreach($namePet as $key1 => $sel)
                                        @if($key == $key1)
                                        {{$sel}}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$sell}}
                                    </td>
                                    <td>
                                        @foreach($userPet as $key1 => $sel)
                                        @if($key == $key1)
                                        {{$sel}}
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sản phẩm phụ kiện bán chạy tháng này
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Người mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataAcc as $key => $sell)
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>
                                        @foreach($nameAcc as $key1 => $sel)
                                        @if($key == $key1)
                                        {{$sel}}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$sell}}
                                    </td>
                                    <td>
                                        @foreach($userAcc as $key1 => $sel)
                                        @if($key == $key1)
                                        {{$sel}}
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
