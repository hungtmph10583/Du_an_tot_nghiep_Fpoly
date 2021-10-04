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
                                <th>Tên giống loài</th>
                                <th class="text-center">Số lượng sản phẩm</th>
                                <th class="text-center">Trạng thái</th>
                                <th><a href="{{route('breed.add')}}" class="btn btn-info">Thêm giống loài</a></th>
                            </thead>
                            <tbody>
                                @foreach($breed as $b)
                                <tr>
                                    <td>{{(($breed->currentPage()-1)*7) + $loop->iteration}}</td>
                                    <td>
                                        <span class="btn btn-info btn-sm text-light">{{$b->category->name}}</span>
                                    </td>
                                    <td>{{$b->name}}</td>
                                    <td class="text-center">{{count($b->products)}}</td>
                                    <td class="text-center">
                                        <i class="{{ $b->status == 1 ? 'fas fa-eye text-success' : 'fas fa-eye-slash text-danger'  }}"></i>
                                    </td>
                                    <td>
                                        <a href="{{route('breed.detail', ['id' => $b->id])}}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                        <a href="{{route('breed.edit', ['id' => $b->id])}}" class="btn btn-success"><i class="far fa-edit"></i></a>
                                            <a class="btn btn-danger" href="{{route('breed.remove', ['id' => $b->id])}}" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$breed->links()}}
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