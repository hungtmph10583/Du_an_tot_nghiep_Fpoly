@section('title', 'Thêm tài khoản')
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
                        <li class="breadcrumb-item active">Thêm tài khoản</li>
                    </ol>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

	<!-- END: Subheader -->
	<section class="content">
        <div class="container-fluid pb-1">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Tên tài khoản">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="Nhập vào email">
                                    @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{old('phone')}}" placeholder="Nhập vào số điện thoại">
                                    @error('phone')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror   
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Mật khẩu">
                                    @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name="cfpassword" class="form-control" value="{{old('cfpassword')}}" placeholder="Nhập lại mật khẩu">
                                    @error('cfpassword')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
								<!-- <div id="cc" style="display: none">
									<img class="add-product-preview-img" id="blah" src="#" alt="your image" />
								</div> -->
                                <div class="form-group">
                                    <label for="">Ảnh đại diện</label>
                                    <input type="file" name="uploadfile" id="imgInp" class="form-control">
                                    @error('uploadfile')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                @hasrole('admin')
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <div class="form-control">
                                        <label class="pr-1">
                                            <input type="radio" name="active" value="1" checked> Hiển thị
                                        </label>
                                        <label class="pl-1">
                                            <input type="radio" name="active" value="0"> Ẩn
                                        </label>
                                    </div>
                                </div>
                                @endhasrole
                                @hasrole('admin')
                                <div class="form-group">
                                    <label for="">Quyền hạn</label>
                                    <select name="role_id" class="form-control">
                                        @foreach($roles as $r)
                                        <option value="{{$r->id}}" @if($r->id == old('role_id')) selected @endif>{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endhasrole
                            </div>
                            <div class="text-right pl-2">
                                <button type="submit" class="btn btn-success">Lưu</button>
                                <a href="{{route('user.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('pagejs')
    <script>
		// var a = '';
        // function readURL(input) {

		// 	if (input.files && input.files[0]) {
		// 		var reader = new FileReader();
		// 			// $('#cc').append(`
		// 			// 	<img class="add-product-preview-img" id="blah" src="#" alt="your image" />
		// 			// `);
		// 			document.getElementById("cc").style.display = 'block';
				

		// 		reader.onload = function(e) {
		// 			$('#blah').attr('src', e.target.result);
		// 		}
		// 		reader.readAsDataURL(input.files[0]);
		// 		}
		// 	}

		// 	$("#imgInp").change(function() {
		// 		readURL(this);
			
		// });
    </script>
@endsection