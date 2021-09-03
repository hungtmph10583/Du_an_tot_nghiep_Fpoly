@section('title', 'Danh sách sách')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách sách</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <div class="card card-success card-outline">
            <div class="card-header">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-9">

                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="text" name="keyword" @isset($searchData['keyword'])
                                    value="{{$searchData['keyword']}}" @endisset placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <th>STT</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Country</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Quantity</th>
                            <th>
                                <a href="{{route('book.add')}}" class="btn btn-primary">Thêm tài khoản</a>
                            </th>
                        </thead>
                        <tbody>
                            @foreach($books as $b)
                            <tr>
                                <td>{{(($books->currentPage()-1)*5) + $loop->iteration}}</td>
                                <td>{{$b->name}}</td>
                                <td><img src="{{asset( 'storage/' . $b->image)}}" width="70" /></td>
                                <td>{{$b->categories->name}}</td>
                                <td>{{$b->countries->name}}</td>
                                <td>{{$b->price}}</td>
                                <td>
                                    @if($b->status == 0)
                                    Đã hết sách
                                    @else
                                    Còn sách
                                    @endif
                                </td>
                                <td>{{$b->quantity}}</td>

                                <td>
                                    <a href="{{route('book.detail', ['id' => $b->id])}}" class="btn btn-info"><i
                                            class="far fa-eye"></i></a>
                                    <a href="{{route('book.remove', ['id' => $b->id])}}" class="btn btn-danger"
                                        onclick="confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                    <a href="{{route('book.edit', ['id' => $b->id])}}" class="btn btn-success">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{$books->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection