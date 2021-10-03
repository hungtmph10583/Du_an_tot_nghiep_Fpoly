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
                        <li class="breadcrumb-item card-title">Danh sách sản phẩm</li>
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
                                    <label for="">Tên sản phẩm</label>
                                    <input class="form-control" placeholder="Search" type="text" name="keyword" @isset($searchData['keyword']) value="{{$searchData['keyword']}}" @endisset>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Danh mục sản phẩm</label>
                                    <select class="form-control" name="cate_id" >
                                        <option value="">Tất cả</option>
                                        @foreach($category as $c)
                                        <option @if(isset($searchData['cate_id']) && $c->id == $searchData['cate_id']) selected @endif value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
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
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <select class="form-control" name="comp_id" >
                                        <option value="">Tất cả</option>
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
                                <th>Tên sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Danh mục</th>
                                <th>Giống loài</th>
                                <th>Số lượng</th>
                                <th>Giá sản phẩm</th>
                                <th>Giảm giá</th>
                                <th><a href="{{route('product.add')}}" class="btn btn-info">Tạo mới</a></th>
                            </thead>
                            <tbody>
                                @foreach($product as $p)
                                <tr>
                                    <td>{{(($product->currentPage()-1)*5) + $loop->iteration}}</td>
                                    <td>{{$p->name}}</td>
                                    <td><img src="{{asset( 'storage/' . $p->image)}}" width="70" /></td>
                                    <td>{{$p->category->name}}</td>
                                    <td>{{$p->breed->name}}</td>
                                    <td>{{number_format($p->quantity)}}</td>
                                    <td>{{number_format($p->price)}} <b>VND</b></td>
                                    <td>
                                        @isset($p->tags)
                                            @foreach($p->tags as $tg)
                                                <span class="btn btn-success mb-1">{{$tg->name}}</span>
                                                @if(count($p->tags) > 2)<br>@endif
                                            @endforeach
                                        @endisset
                                    </td>
                                    <td>
                                        <a href="{{route('product.edit', ['id' => $p->id])}}" class="btn btn-success"><i class="far fa-edit"></i></a>
                                        <a href="{{route('product.remove', ['id' => $p->id])}}" class="btn btn-danger" onclick="alert('Bạn có chắc muốn xóa sản phẩm này?')"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$product->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection