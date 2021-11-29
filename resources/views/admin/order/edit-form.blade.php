@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('order.index')}}">Danh sách Đơn
                            hàng</a></li>
                    <li class="breadcrumb-item active">Sửa Đơn hàng</li>
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
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    Chi tiết đơn hàng
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Trạng thái thanh toán</label>
                                <select name="" id="" class="form-control">
                                    <option value="">Đã thanh toán</option>
                                    <option value="">Chưa thanh toán</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Trạng thái giao hàng</label>
                                <select name="" id="" class="form-control">
                                    <option value="">Đã giao hàng</option>
                                    <option value="">Đang giao hàng</option>
                                    <option value="">Chưa giao hàng</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div>
                                    <b>Khách hàng: </b>
                                    <b>Mạnh Hùng</b>
                                </div>
                                <div>
                                    <b>Email: </b>
                                    <span>hungtmph10583@gmail.com</span>
                                </div>
                                <div>
                                    <b>Số điện thoại: </b>
                                    <span>0336126726</span>
                                </div>
                                <div>
                                    <b>Địa chỉ giao hàng: </b>
                                    <span>199 Hồ Tùng Mậu</span>
                                </div>
                                <div>
                                    <b>Quốc gia: </b>
                                    <span>Vietnam</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Mã đơn hàng</div>
                                    <div class="col">105468-54231</div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Trạng thái đơn hàng</div>
                                    <div class="col">
                                        <span class="btn btn-success btn-sm text-light">Đã thanh toán</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Ngày đặt hàng</div>
                                    <div class="col">25-10-2021 2:25 AM</div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Tổng cộng</div>
                                    <div class="col">8.825.000đ</div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Phương thức thanh toán</div>
                                    <div class="col">Thanh toán khi nhận hàng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-center">Ảnh</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Hình thức giao hàng</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá bán</th>
                                    <th scope="col">Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td class="text-center"><img src="{{ asset('client-theme/images/cate-dog.jpg')}}"
                                            alt="" width="70"></td>
                                    <td>Chó đốm</td>
                                    <td>Giao hàng tận nhà</td>
                                    <td>1</td>
                                    <td>2.500.000đ / sản phẩm</td>
                                    <td>2.500.000đ</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td class="text-center"><img src="{{ asset('client-theme/images/cate-cat.jpg')}}"
                                            alt="" width="70"></td>
                                    <td>Mèo trắng mắt xanh</td>
                                    <td>Giao hàng tận nhà</td>
                                    <td>1</td>
                                    <td>4.500.000đ / sản phẩm</td>
                                    <td>4.500.000đ</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td class="text-center"><img src="{{ asset('client-theme/images/cate-bird.jpg')}}"
                                            alt="" width="70"></td>
                                    <td>Vẹt 7 màu</td>
                                    <td>Giao hàng tận nhà</td>
                                    <td>1</td>
                                    <td>1.800.000đ / sản phẩm</td>
                                    <td>1.800.000đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3">
                            <div class="form-group">
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group">Tổng phụ</div>
                                    <div class="col form-group">8.800000đ</div>
                                </div>
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group">Thuế</div>
                                    <div class="col form-group">0.000đ</div>
                                </div>
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group">Giao hàng</div>
                                    <div class="col form-group">25.000đ</div>
                                </div>
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group"><b>Tổng tiền</b></div>
                                    <div class="col form-group"><b>8.825.000đ</b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('order.index')}}" class="btn btn-danger">Hủy</a>
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