@extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách Slide</li>
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
                <div class="card-body">
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <th>STT</th>
                                <th>Ảnh slide</th>
                                <th class="text-center">Trạng thái</th>
                                <th><a href="{{route('slide.add')}}" class="btn btn-outline-info float-right">Thêm slide</a></th>
                            </thead>
                            <tbody>
                                @foreach($slide as $sl)
                                <tr>
                                    <td>{{(($slide->currentPage()-1)*5) + $loop->iteration}}</td>
                                    <td>
                                        <img width="200" src="{{asset( 'storage/' . $sl->image)}}" alt="slide này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                                    </td>
                                    <td class="text-center">
                                        <i class="{{ $sl->status == 0 ? 'far fa-times-circle text-danger' : 'far fa-check-circle text-success'  }}"></i>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="{{route('slide.edit', ['id' => $sl->id])}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            <a href="{{route('slide.remove', ['id' => $sl->id])}}" class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa slide này?')"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$slide->links()}}
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