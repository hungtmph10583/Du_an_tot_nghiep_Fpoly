@extends('layouts.admin.main')
@section('content')
<!-- @php
    use Illuminate\Support\Facades\Auth;
@endphp
@dump(Auth::user()) -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item card-title">Danh sách phụ kiện</li>
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tên phụ kiện</label>
                                    <input class="form-control" placeholder="Search" type="text" name="keyword" @isset($searchData['keyword']) value="{{$searchData['keyword']}}" @endisset>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Danh mục phụ kiện</label>
                                    <select class="form-control" name="cate_id" >
                                        <option value="">Tất cả</option>
                                        @foreach($category as $c)
                                        <option @if(isset($searchData['cate_id']) && $c->id == $searchData['cate_id']) selected @endif value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Sắp xếp theo</label>
                                    <select class="form-control" name="order_by" >
                                        <option value="0">Mặc định</option>
                                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 1) selected @endif  value="1">Tên alphabet</option>
                                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 2) selected @endif value="2">Tên giảm dần alphabet</option>
                                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 3) selected @endif value="3">Giá tăng dần</option>
                                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 4) selected @endif value="4">Giá giảm dần</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-info mt-2">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <th>STT</th>
                                <th>Tên phụ kiện</th>
                                <th>Ảnh</th>
                                <th>Danh mục</th>
                                <th>Số lượng</th>
                                <th>Giá bán</th>
                                <th>trạng thái</th>
                                <th><a href="{{route('accessory.add')}}" class="btn btn-info">Thêm phụ kiện</a></th>
                            </thead>
                            <tbody>
                                @foreach($accessory as $p)
                                <tr>
                                    <td>{{(($accessory->currentPage()-1)*5) + $loop->iteration}}</td>
                                    <td>{{$p->name}}</td>
                                    <td><img src="{{asset( 'storage/' . $p->image)}}" width="70" /></td>
                                    <td>{{$p->category->name}}</td>
                                    <td>{{number_format($p->quantity)}}</td>
                                    <td>{{number_format($p->price)}} <span>VND</span></td>
                                    <td>
                                        <span class="btn {{ $c->status == 1 ? 'btn-success' : 'btn-danger'}} btn-sm text-light">
                                            {{ $c->status == 1 ? 'Còn hàng' : 'Hết hàng'  }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{route('accessory.detail', ['id' => $p->id])}}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                        <a href="{{route('accessory.edit', ['id' => $p->id])}}" class="btn btn-success"><i class="far fa-edit"></i></a>
                                        <a href="{{route('accessory.remove', ['id' => $p->id])}}" class="btn btn-danger" onclick="confirm('Bạn có chắc muốn xóa phụ kiện này?')"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$accessory->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection