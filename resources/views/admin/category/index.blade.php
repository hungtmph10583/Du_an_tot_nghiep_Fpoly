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
                                    <label for="">Tên danh mục</label>
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
                                <th>Tên danh mục</th>
                                <th class="text-center">Kiểu danh mục</th>
                                <th><a href="{{route('category.add')}}" class="btn btn-outline-info float-right">Thêm danh mục</a></th>
                            </thead>
                            <tbody>
                                @foreach($cates as $c)
                                <tr>
                                    <td>{{(($cates->currentPage()-1)*7) + $loop->iteration}}</td>
                                    <td>{{$c->name}}</td>
                                    <td class="text-center">
                                        <span class="btn {{ $c->categoryType->id == 1 ? 'btn-info' : 'btn-warning' }} btn-sm text-light">
                                            {{ $c->categoryType->id == 1 ? 'Thú cưng' : 'Phụ kiện' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="{{route('category.detail', ['id' => $c->id])}}" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('category.edit', ['id' => $c->id])}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            @if(count($c->products) > 0)
                                                <a class="btn btn-outline-danger" href="{{route('category.remove', ['id' => $c->id])}}" onclick="return confirm('Danh mục này đang tồn tại sp')">
                                            @else
                                                <a class="btn btn-outline-danger" href="{{route('category.remove', ['id' => $c->id])}}" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
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
                            {{$cates->links()}}
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