@section('title', 'Cập nhật tài khoản')
@extends('layouts.admin.main')
@section('content')
<!-- BEGIN: Subheader -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item">
                        <a class="card-title" href="{{route('user.index')}}">Danh sách tài khoản</a>
                    </li>
                    <li class="breadcrumb-item active">Cập nhật tài khoản</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- END: Subheader -->
@include('layouts.admin.message')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-info card-outline">
                <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{asset( 'storage/' . $model->avatar)}}" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$model->name}}</h3>
                        @if(count($model->roles)>0) @foreach($model->roles as $ro)
                        <p class="text-muted text-center">{{$ro->name}}</p>
                        @endforeach @else
                        <p class="text-muted text-center">Khách hàng</p>
                        @endif

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Vai trò</b> 
                                @if(count($model->roles)>0) 
                                    @foreach($model->roles as $ro)
                                        <b class="float-right text-info">{{$ro->name}}</b> 
                                    @endforeach 
                                @else
                                    <b class="float-right text-info">Khách hàng</b>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <b>Trạng thái</b>
                                <span class="btn {{ $model->status == 1 ? 'btn-success' : 'btn-warning' }} float-right btn-sm text-light">
									{{ $model->status == 1 ? 'Hoạt động' : 'Đừng hoạt động' }}
								</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <span>Cập nhật thông tin tài khoản</span>
                    </div>
                    <div class="card-body">
                        @if(session('msg') != null)
                        <b class="text-left text-danger">{{session('msg')}}</b>
                        @endif
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Tên tài khoản</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="name" class="form-control" value="{{$model->name}}" placeholder="Tên tài khoản">
                                    <span class="text-danger error_text name_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Địa chỉ email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" value="{{$model->email}}" placeholder="Nhập vào email">
                                    <span class="text-danger error_text email_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName2" class="col-sm-2 col-form-label">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" class="form-control" value="{{$model->phone}}" placeholder="Nhập vào số điện thoại">
                                    <span class="text-danger error_text phone_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName2" class="col-sm-2 col-form-label">Ảnh đại diện</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" id="imgInp" class="form-control">
                                    <span class="text-danger error_text image_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName2" class="col-sm-2 col-form-label">Trạng thái</label>
                                <div class="col-sm-10 form-group">
                                    <div class="form-control">
                                        <label class="pr-1">
                                            <input type="radio" name="status" value="1" @if($model->status == 1)
                                            checked @endif> Hoạt dộng
                                        </label>
                                        <label class="pl-1">
                                            <input type="radio" name="status" value="0" @if($model->status == 0)
                                            checked @endif> Tạm dừng hoạt động
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Vai trò</label>
                                <div class="col-sm-10 form-group">
                                    <select name="role_id" class="form-control" id="role">
                                        <option value="">Khách hàng</option>
                                        @foreach($role as $r)
                                        <option value="{{$r->id}}" @foreach($mdh_role as $mdh) @if($model->
                                            id == $mdh->model_id)
                                            @if($r->id == $mdh->role_id)
                                            selected
                                            @endif
                                            @endif
                                            @endforeach>{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error_text role_id_error"></span>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-info">Lưu</button>
                                    <a href="{{route('user.index')}}" class="btn btn-danger">Hủy</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
$("#imgInp").change(function() {
    readURL(this);
});
$(".btn-info").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    let nameValue = $('#name').val();
    let name = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
    formData.set('name', name);
    $.ajax({
        url: "{{route('user.saveEdit',['id'=>$model->id])}}",
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(data) {
            $(document).find('span.error_text').text('');
        },
        success: function(data) {
            console.log(data)
            $('#realize').attr('href', data.url)
            $('#realize').text('Người dùng')
            if (data.status == 0) {
                showErr = '<div class="alert alert-danger" role="alert" id="danger">';
                $.each(data.error, function(key, value) {
                    showErr +=
                        '<span class="fas fa-times-circle text-danger mr-2"></span>' +
                        value[0] +
                        '<br>';
                    $('span.' + key + '_error').text(value[0]);
                });
                $('.modal-body').html(showErr);
            } else {
                $("#myModal").modal('show');
                $('.modal-body').html(
                    '<div class="alert alert-success" role="alert"><span class="fas fa-check-circle text-success mr-2"></span>' +
                    data.message + '</div>')
            }
        },
    });
});
$('select').map(function(i, dom) {
    var idSelect = $(dom).attr('id');
    $('#' + idSelect).select2({
        placeholder: 'Select ' + idSelect
    });
})
</script>
@endsection