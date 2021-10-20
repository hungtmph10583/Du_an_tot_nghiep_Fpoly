@extends('layouts.admin.main')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item card-title">Danh sách bài viết</li>
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
                                    <label for="">Tên bài viết</label>
                                    <input class="form-control" placeholder="Search" type="text" name="keyword" @isset($searchData['keyword']) value="{{$searchData['keyword']}}" @endisset>
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
                                <th>Tiêu đề bài viết</th>
                                <th class="text-center">Ảnh</th>
                                <th class="text-center">Người tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th><a href="{{route('news.add')}}" class="btn btn-info">Thêm bài viết</a></th>
                            </thead>
                            <tbody>
                                @foreach($news as $n)
                                <tr>
                                    <td>{{(($news->currentPage()-1)*7) + $loop->iteration}}</td>
                                    <td>{{$n->title}}</td>
                                    <td class="text-center"><img src="{{asset( 'storage/' . $n->image)}}" width="70" /></td>
                                    <td class="text-center">{{$n->user->name}}</td>
                                    <td class="text-center">
                                        <span class="btn {{ $n->status == 1 ? 'btn-success' : 'btn-danger'}} btn-sm text-light">
                                            {{ $n->status == 1 ? 'Active' : 'Inactive'  }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{route('news.detail', ['id' => $n->id])}}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                        <a href="{{route('news.edit', ['id' => $n->id])}}" class="btn btn-success"><i class="far fa-edit"></i></a>
                                        <a class="btn btn-danger" href="{{route('news.remove', ['id' => $n->id])}}" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$news->links()}}
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