@section('title', 'Danh sách tài khoản')
@extends('layouts.admin.main')
@section('content')
	<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item card-title">Danh sách tài khoản</li>
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
							<div class="col-9"></div>
                            <div class="col-3">
								<div class="input-group input-group-sm">
									<input class="form-control" type="text" name="keyword" @isset($searchData['keyword']) value="{{$searchData['keyword']}}" @endisset placeholder="Search">
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
                                <th>Avatar</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Active</th>
                                <th><a href="{{route('user.add')}}" class="btn btn-primary">Tạo mới</a></th>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                <tr>
                                    <td>{{(($users->currentPage()-1)*20) + $loop->iteration}}</td>
                                    <td>{{$u->name}}</td>
                                    <td><img src="{{asset( 'storage/' . $u->avatar)}}" width="70" /></td>
                                    <td>{{$u->email}}</td>
                                    <td>{{$u->phone}}</td>
                                    <td><i class="{{ $u->active == 1 ? 'fa fa-check text-success' : 'fa fa-times text-danger' }} pl-3"></i></td>
                                    <td>
                                        <a href="{{route('user.profile', ['id' => $u->id])}}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                        <a href="{{route('user.edit', ['id' => $u->id])}}" class="btn btn-success"><i class="far fa-edit"></i></a>
                                        <a href="{{route('user.remove', ['id' => $u->id])}}" class="btn btn-danger" onclick="alert('Bạn có chắc muốn xóa tài khoản này?')">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$users->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
		</section>
    <!-- /.content -->
@endsection