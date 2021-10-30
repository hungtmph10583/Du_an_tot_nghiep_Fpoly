@extends('layouts.admin.main')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item card-title">Tất cả các phiếu giảm giá</li>
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
                                    <label for="">Tên giảm giá</label>
                                    <input class="form-control" placeholder="Search" type="text" name="keyword" @isset($searchData['keyword']) value="{{$searchData['keyword']}}" @endisset>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Sắp xếp theo</label>
                                    <select class="form-control" name="order_by" >
                                        <option value="0">Mặc định</option>
                                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 1) selected @endif  value="1">Thú Cưng</option>
                                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 2) selected @endif value="2">Phụ kiện</option>
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
                                <th>Code</th>
                                <th class="text-center">Kiểu</th>
                                <th class="text-center">Ngày bắt đầu</th>
                                <th class="text-center">Ngày kết thúc</th>
                                <th>
                                    <a href="{{route('coupon.add')}}" class="btn btn-outline-info float-right">Thêm phiếu giảm giá mới</a>
                                </th>
                            </thead>
                            <tbody>
                                @foreach($model as $cp)
                                <tr>
                                    <td>{{(($model->currentPage()-1)*7) + $loop->iteration}}</td>
                                    <td>{{$cp->code}}</td>
                                    <td class="text-center">
                                        {{$cp->couponType->name}}
                                    </td>
                                    <td class="text-center">{{$cp->start_date}}</td>
                                    <td class="text-center">{{$cp->end_date}}</td>
                                    <td>
                                        <span class="float-right">
                                            <a href="{{route('coupon.edit', ['id' => $cp->id])}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            @if(count($cp->products) > 0)
                                                <a class="btn btn-outline-danger" href="{{route('coupon.remove', ['id' => $cp->id])}}" onclick="return confirm('Giảm giá này đang tồn tại sp')">
                                            @else
                                                <a class="btn btn-outline-danger" href="{{route('coupon.remove', ['id' => $cp->id])}}" onclick="return confirm('Bạn có chắc muốn xóa giảm giá này?')">
                                            @endif
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$model->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('pagejs')
    <script>
        
    </script>
@endsection