@section('title', 'Thông tin tài khoản')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="card card-secondary my-0">
			<div class="card-header">
				<ol class="breadcrumb float-sm-left ">
					<li class="breadcrumb-item card-title">Profile</li>
				</ol>
			</div>
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
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

						<p class="text-muted text-center">Designer</p>

						<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
							<b>Quyền hạn</b> <b class="float-right text-danger">Admin</b>
						</li>
						<li class="list-group-item">
							<b>Trạng thái</b>
							<i class="{{ $user->active == 1 ? 'fa fa-check text-success' : 'fa fa-times text-danger' }} float-right pr-3"></i>
						</li>
						<li class="list-group-item">
							<b>
								<i class="fa fa-mobile" aria-hidden="true"></i> Phone
							</b>
							<p class="float-right">{{$user->phone}}</p>
						</li>
						</ul>

						<a href="#" class="btn btn-success btn-block"><b>Sửa tài khoản</b></a>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
			<div class="col-md-9">
				<div class="card card-success card-outline">
					<div class="card-header">
						<h5>Personal information</h5>
					</div>
					<div class="card-body">
						<strong><i class="fab fa-facebook-square"></i> Facebook</strong>

						<p class="text-muted">
						@foreach($psInfor as $pf)
							@if($pf->user_id === $user->id)
								<a href="{{$pf->facebook_url}}">{{$pf->facebook_url}}</a>
							@endif
						@endforeach
						</p>

						<hr>

						<strong><i class="fab fa-instagram-square"></i> Instagram</strong>

						<p class="text-muted">
							@foreach($psInfor as $pf)
								@if($pf->user_id === $user->id)
									{{$pf->mail_url}}
								@endif
							@endforeach
						</p>

						<hr>

						<strong><i class="fab fa-twitter-square"></i> Twitter</strong>

						<p class="text-muted">
							@foreach($psInfor as $pf)
								@if($pf->user_id === $user->id)
									{{$pf->mail_url}}
								@endif
							@endforeach
						</p>

						<hr>

						<strong><i class="fas fa-envelope"></i> Email</strong>

						<p class="text-muted">
							@foreach($psInfor as $pf)
								@if($pf->user_id === $user->id)
									{{$pf->mail_url}}
								@endif
							@endforeach
						</p>
					</div>
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection