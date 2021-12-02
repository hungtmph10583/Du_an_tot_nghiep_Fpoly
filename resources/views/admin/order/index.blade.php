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
                                    <label for="">Search</label>
                                    <input class="form-control" placeholder="Search" type="text" name="keyword" @isset($searchData['keyword']) value="{{$searchData['keyword']}}" @endisset>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Sắp xếp theo</label>
                                    <select class="form-control" name="order_by" >
                                        <option value="">Mặc định</option>
                                        <option value="1">Đơn đang chờ xử lí</option>
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
                                @foreach($order as $value)
                                <tr>
                                    <td>{{(($order->currentPage()-1)*7) + $loop->iteration}}</td>
                                    <td>{{$value->code}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->created_at->format('d/m/Y')}}</td>
                                    <!-- <td>{{number_format($value->grand_total,0,',','.')}}<span>đ</span></td> -->
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
                                                Đang chờ xử lí
                                            @elseif($value->delivery_status == 2)
                                                Đang giao hàng
                                            @elseif($value->delivery_status == 3)
                                                Giao hàng thành công
                                            @elseif($value->delivery_status == 4)
                                                Khách đã hủy đơn hàng
                                            @elseif($value->delivery_status == 0)
                                                Hủy đơn hàng
                                            @else
                                                Lỗi code
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <i class="{{ $value->payment_status == 1 ? 'far fa-times-circle text-danger' : 'far fa-check-circle text-success'  }}"></i>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="#" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('order.edit', ['id' => $value->id])}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
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
