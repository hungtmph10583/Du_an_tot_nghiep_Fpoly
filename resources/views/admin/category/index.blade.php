@section('title', 'Danh sách tài khoản')
@extends('layouts.admin.main')
@section('content')


<br>

<section class="content">
    <div class="container-fluid pb-1">
        <div class="card card-success card-outline">
            <div class="card-header">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Tên sp:</label>
                                <input type="text" name="keyword" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Sắp xếp theo</label>
                                <select name="order_by" class="form-control">
                                    <option value="">Mặc định</option>
                                    @foreach(config('common.cate_order_by') as $k => $val)
                                    <option value="{{$k}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button class="btn btn-sm btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <th>STT</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Trạng thái</th>
                            <th>show_menu</th>
                            <th>Số lượng sản phẩm</th>
                            <th>
                                hành động
                            </th>
                            <th><a class="btn btn-primary" href="{{route('category.add')}}">Thêm danh mục</a></th>
                        </thead>
                        <tbody>
                            @foreach($cate as $p)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$p->name}}</td>
                                <td>
                                    @if($p->status == 1) Hoạt động
                                    @elseif($p->status == 0) Không hoạt động
                                    @endif
                                </td>
                                <td>
                                    @if($p->show_menu == 1) Hoạt động
                                    @elseif($p->show_menu == 0) Không hoạt động
                                    @endif
                                </td>
                                <td>{{count($p->books)}}</td>
                                <td>
                                    <a href="#" class="btn btn-info"><i class="far fa-eye"></i></a>
                                    <a href="{{route('category.edit', ['id' => $p->id])}}" class="btn btn-success">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{route('category.remove', ['id' => $p->id])}}" class="btn btn-danger">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-6 offset-3 d-flex justify-content-center">
        {{$cate->links()}}
    </div>
</div>
@endsection