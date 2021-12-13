@section('title', 'Thông tin tài khoản') @extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item">
                        <a class="card-title" href="{{route('user.index')}}">Danh sách tài khoản</a>
                    </li>
                    <li class="breadcrumb-item active">Profile</li>
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
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{asset( 'storage/' . $user->avatar)}}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{$user->name}}</h3>
                        @if(count($user->roles)>0) @foreach($user->roles as $role)
                        <p class="text-muted text-center">{{$role->name}}</p>
                        @endforeach @else
                        <p class="text-muted text-center">Khách hàng</p>
                        @endif

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Vai trò</b> @if(count($user->roles)>0) @foreach($user->roles as $role)
                                <b class="float-right text-danger">{{$role->name}}</b> @endforeach @else
                                <b class="float-right text-info">Khách hàng</b> @endif
                            </li>
                            <li class="list-group-item">
                                <b>Trạng thái</b>
                                <span class="btn {{ $user->status == 1 ? 'btn-success' : 'btn-warning' }} float-right btn-sm text-light">
									{{ $user->status == 1 ? 'Hoạt động' : 'Đừng hoạt động' }}
								</span>
                            </li>
                        </ul>
                        @hasanyrole('admin|manage')
                        <a href=" 
								@if($user->id === 1)
									@hasrole('admin')
										{{route('user.edit', ['id' => $user->id])}}
									@else
										#
									@endhasrole
								@else
									{{route('user.edit', ['id' => $user->id])}}
								@endif
								" class="btn btn-success btn-block" @if(Auth::user()->id === $user->id)
									{{route('user.edit', ['id' => $user->id])}}
								@elseif(Auth::user()->id > 1 && $user->id == 1)
									onclick="alert('Không thể sửa thông tin tài khoản này :))')"
								@else

								@endif
								><b>Sửa tài khoản</b></a> @else @if(Auth::user()->id === $user->id)
                        <a href="{{route('user.edit', ['id' => $user->id])}}" class="btn btn-success btn-block"><b>Sửa tài khoản</b></a> @endif @endhasanyrole
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5>Thông tin tài khoản</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tên tài khoản</label>
                                    <input type="text" name="name" class="form-control" value="{{$user->name}}" placeholder="Tên tài khoản" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{$user->email}}" placeholder="Nhập vào email" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{$user->phone}}" placeholder="Nhập vào số điện thoại" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <input type="text" class="form-control" value="@if($user->status == 1) Hoạt động @else Đừng hoạt động @endif" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Vai trò</label>
                                    @if(count($user->roles)>0) @foreach($user->roles as $role)
                                    <input type="text" class="form-control" disabled value="{{$role->name}}">
                                    @endforeach @else
                                    <input type="text" class="form-control" disabled value="Khách hàng">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection