@section('title', 'Danh sách tài khoản')
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
							<img class="profile-user-img img-fluid img-circle" src="{{asset( 'storage/' . Auth::user()->avatar)}}" alt="User profile picture">
						</div>

						<h3 class="profile-username text-center">{{Auth::user()->name}}</h3>

						<p class="text-muted text-center">Software Engineer</p>

						<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
							<b>Followers</b> <a class="float-right">1,322</a>
						</li>
						<li class="list-group-item">
							<b>Following</b> <a class="float-right">543</a>
						</li>
						<li class="list-group-item">
							<b>Friends</b> <a class="float-right">13,287</a>
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
						B.S. in Computer Science from the University of Tennessee at Knoxville
						</p>

						<hr>

						<strong><i class="fab fa-instagram-square"></i> Instagram</strong>

						<p class="text-muted">Malibu, California</p>

						<hr>

						<strong><i class="fab fa-twitter-square"></i> Twitter</strong>

						<p class="text-muted">
						<span class="tag tag-danger">UI Design</span>
						<span class="tag tag-success">Coding</span>
						<span class="tag tag-info">Javascript</span>
						<span class="tag tag-warning">PHP</span>
						<span class="tag tag-primary">Node.js</span>
						</p>

						<hr>

						<strong><i class="fas fa-envelope"></i> Email</strong>

						<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
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