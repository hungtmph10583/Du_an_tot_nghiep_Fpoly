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
                                <th><a href="{{route('blog.add')}}" class="btn btn-outline-info float-right">Thêm bài viết</a></th>
                            </thead>
                            <tbody>
                                @foreach($blog as $n)
                                <tr>
                                    <td>{{(($blog->currentPage()-1)*7) + $loop->iteration}}</td>
                                    <td>{{$n->title}}</td>
                                    <td>
                                        <span class="float-right">
                                            <a href="{{route('blog.detail', ['id' => $n->id])}}" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                                            <a href="{{route('blog.edit', ['id' => $n->id])}}" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                                            <a class="btn btn-outline-danger" href="{{route('blog.remove', ['id' => $n->id])}}" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$blog->links()}}
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