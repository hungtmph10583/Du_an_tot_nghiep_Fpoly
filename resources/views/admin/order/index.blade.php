@extends('layouts.admin.main')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item card-title">Danh sách danh mục</li>
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
                <div class="card-body">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Search</label>
                                    <input class="form-control" placeholder="Search" type="text">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Sắp xếp theo</label>
                                    <select class="form-control" name="order_by" >
                                        <option value="0">Mặc định</option>
                                        <option value="1">Đơn đã giao</option>
                                        <option value="2">Đơn đã xác nhận</option>
                                        <option value="2">Đơn đã thanh toán</option>
                                        <option value="2">Đơn chưa thanh toán</option>
                                        <option value="2">Đơn đã huỷ</option>
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
                                <th>Mã đặt hàng</th>
                                <th>Số lượng sản phẩm</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Giao hàng</th>
                                <th>Thanh toán</th>
                                <th><span class="float-right mr-4">Lựa chọn</span></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>121252-013251</td>
                                    <td>4</td>
                                    <td>Mạnh Hùng</td>
                                    <td>3.205.000 <span>đ</span></td>
                                    <td>
                                        <span class="btn btn-sm btn-info text-light">Đã giao hàng</span>
                                    </td>
                                    <td>
                                        <span class="btn btn-sm btn-success text-light">Đã thanh toán</span>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="#" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('order.edit')}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-outline-danger" onclick="confirm('Bạn có chắc muốn xóa đơn hàng này?')"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>121252-018741</td>
                                    <td>2</td>
                                    <td>Huy</td>
                                    <td>205.000 <span>đ</span></td>
                                    <td>
                                        <span class="btn btn-sm btn-secondary text-light">Đang chờ sử lý</span>
                                    </td>
                                    <td>
                                        <span class="btn btn-sm btn-danger text-light">Chưa thanh toán</span>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="#" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('order.edit')}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-outline-danger" onclick="confirm('Bạn có chắc muốn xóa đơn hàng này?')"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>121252-084241</td>
                                    <td>3</td>
                                    <td>Ngoc</td>
                                    <td>405.000 <span>đ</span></td>
                                    <td>
                                        <span class="btn btn-sm btn-danger text-light">Hủy đơn hàng</span>
                                    </td>
                                    <td>
                                        <span class="btn btn-sm btn-danger text-light">Chưa thanh toán</span>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="#" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('order.edit')}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-outline-danger" onclick="confirm('Bạn có chắc muốn xóa đơn hàng này?')"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>121252-084741</td>
                                    <td>1</td>
                                    <td>Thọ</td>
                                    <td>150.000 <span>đ</span></td>
                                    <td>
                                        <span class="btn btn-sm btn-primary text-light">Đã xác nhận</span>
                                    </td>
                                    <td>
                                        <span class="btn btn-sm btn-success text-light">Đã thanh toán</span>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="#" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('order.edit')}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-outline-danger" onclick="confirm('Bạn có chắc muốn xóa đơn hàng này?')"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$order->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection