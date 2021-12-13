@section('title', 'Sửa tài khoản')
@extends('layouts.admin.main')
@section('content')
	<!-- BEGIN: Subheader -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="card card-secondary my-0">
				<div class="card-header">
					<ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item">
							<a class="card-title" href="{{route('user.index')}}">Danh sách tài khoản</a>
						</li>
                        <li class="breadcrumb-item active">Sửa tài khoản</li>
                    </ol>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- END: Subheader -->
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<!-- Profile Image -->
					<div class="card card-success card-outline">
						<div class="card-body box-profile">
							<div class="text-center" id="cc">
								<img class="profile-user-img img-fluid img-circle" id="blah" src="{{asset( 'storage/' . $model->avatar)}}" alt="User profile picture">
							</div>

							<h3 class="profile-username text-center">{{$model->name}}</h3>
							@foreach($mdh_role as $mdhr)
								@if($mdhr->model_id === $model->id)
								<p class="text-muted text-center">
									{{ucfirst($mdhr->role->name)}}
								</p>
								@endif
							@endforeach

							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item">
									<b>Vai trò</b>
									@foreach($mdh_role as $mdhr)
										@if($mdhr->model_id === $model->id)
										<b class="float-right {{ ($mdhr->role_id === 1 ? 'text-danger' : ($mdhr->role_id === 2 ? 'text-success' : 'text-info')) }}">
											{{ucfirst($mdhr->role->name)}}
										</b>
										@endif
									@endforeach
								</li>
								<li class="list-group-item">
									<b>Trạng thái</b>
									<i class="{{ $model->status == 1 ? 'fa fa-check text-success' : 'fas fa-user-lock text-danger' }} float-right pr-3"></i>
								</li>
							</ul>
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
							@if(session('msg') != null)
								<b class="text-left text-danger">{{session('msg')}}</b>
							@endif
							<form action="" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label for="">Tên tài khoản</label>
										<input type="text" name="name" class="form-control" value="{{$model->name}}" placeholder="Tên tài khoản">
										@error('name')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="form-group">
										<label for="">Email</label>
										<input type="text" name="email" class="form-control" value="{{$model->email}}" placeholder="Nhập vào email">
										@error('email')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="form-group">
										<label for="">Ảnh đại diện</label>
										<input type="file" name="uploadfile" id="imgInp" class="form-control">
										@error('uploadfile')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
								<div class="col-6">
									@hasanyrole('Admin|Manage')
									<div class="form-group">
                                        <label for="">Trạng thái</label>
                                        <div class="form-control">
                                            <label class="pr-1">
                                                <input type="radio" name="status" value="1" @if($model->status == 1) checked @endif> Hoạt động
                                            </label>
                                            <label class="pl-1">
                                                <input type="radio" name="status" value="0" @if($model->status == 0) checked @endif> Dừng hoạt động
                                            </label>
                                        </div>
                                    </div>
									@endhasanyrole
									
									<div class="form-group">
										<label for="">Số điện thoại</label>
										<input type="text" name="phone" class="form-control" value="{{$model->phone}}" placeholder="Nhập vào số điện thoại">
										@error('phone')
											<span class="text-danger">{{$message}}</span>
										@enderror   
									</div>

									@if($model->id != 1)
										@hasrole('Admin')
										<div class="form-group">
											<label for="">Vai trò</label>
											<div class="form-control">
											@foreach($role as $r)
												<label class="pr-1">
													<input type="radio" name="role_id" value="{{$r->id}}"	
													@foreach($mdh_role as $mdh)
														@if($model->id == $mdh->model_id)
															@if($r->id == $mdh->role_id)
															checked
															@endif
														@endif
													@endforeach
													> {{$r->name}}
												</label>
											@endforeach
											</div>
										</div>
										@endhasrole
									@endif
								</div>
								<div class="text-right pl-2">
										<button type="submit" class="btn btn-success">Lưu</button>
									<a href="{{route('user.index')}}" class="btn btn-danger">Hủy</a>
								</div>
							</div>
						</form>
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
@section('pagejs')
    <script>
		var a = '';
        function readURL(input) {

			if (input.files && input.files[0]) {
				var reader = new FileReader();
					// $('#cc').append(`
					// 	<img class="add-product-preview-img" id="blah" src="#" alt="your image" />
					// `);
					document.getElementById("cc").style.display = 'block';
				

				reader.onload = function(e) {
					$('#blah').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
				}
			}

			$("#imgInp").change(function() {
				readURL(this);
			
		});
		
    </script>
@endsection