@extends('layouts.admin.main')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item card-title">Danh sách đơn hàng</li>
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
                                @foreach($order as $value)
                                <tr>
                                    <td>{{(($order->currentPage()-1)*7) + $loop->iteration}}</td>
                                    <td>{{$value->code}}</td>
                                    <td>
                                        <?php
                                            $total = 0;
                                            foreach ($orderDetail as $key => $vldt) {
                                                if ($vldt->order_id == $value->id) {
                                                    $total += $vldt->quantity;
                                                }
                                            }
                                            echo $total.' sản phẩm';
                                        ?>
                                    </td>
                                    <td>{{$value->name}}</td>
                                    <td>{{number_format($value->grand_total,0,',','.')}}<span>đ</span></td>
                                    <td>
                                        <span class="btn btn-sm 
                                            @if($value->delivery_status == 1)
                                                btn-secondary
                                            @elseif($value->delivery_status == 2)
                                                btn-warning
                                            @elseif($value->delivery_status == 3)
                                                btn-success
                                            @elseif($value->delivery_status == 0)
                                                btn-danger
                                            @else
                                                btn-danger
                                            @endif
                                        text-light">
                                            @if($value->delivery_status == 1)
                                                Đang chờ xử lý
                                            @elseif($value->delivery_status == 2)
                                                Đang giao hàng
                                            @elseif($value->delivery_status == 3)
                                                Giao hàng thành công
                                            @elseif($value->delivery_status == 0)
                                                Hủy đơn hàng
                                            @else
                                                Lỗi code
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="btn btn-sm 
                                            @if($value->payment_status == 1)
                                                btn-danger
                                            @elseif($value->payment_status == 2)
                                                btn-success
                                            @else
                                                btn-danger
                                            @endif
                                        text-light">
                                            @if($value->payment_status == 1)
                                                Chưa thanh toán
                                            @elseif($value->payment_status == 2)
                                                Đã thanh toán
                                            @else
                                                Lỗi code
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="#" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('order.edit', ['id' => $value->id])}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-outline-danger" onclick="confirm('Bạn có chắc muốn xóa đơn hàng này?')"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
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