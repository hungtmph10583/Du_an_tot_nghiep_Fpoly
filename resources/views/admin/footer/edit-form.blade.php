@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('footerTitle.index')}}">Danh sách
                            chân trang</a>
                    </li>
                    <li class="breadcrumb-item active">Tạo chân trang</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
@include('layouts.admin.message')
<!-- Main content -->
<section class="content">
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nội dung</label>
                                <input type="text" name="content" id="content" class="form-control"
                                    value="{{$model->content}}">
                                <span class="text-danger error_text content_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tiêu đề footer</label>
                                <select name="footer_title_id" class="form-control" id="Footer-title">
                                    <option value=""></option>
                                    @foreach($footerTitle as $f)
                                    <option value="{{$f->id}}" @if($model->footer_title_id == $f->id) selected
                                        @endif>{{$f->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error_text footer_title_id_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Cài đặt chung</label>
                                <select name="general_setting_id" class="form-control" id="General-setting">
                                    <option value=""></option>
                                    @foreach($general as $g)
                                    <option value="{{$g->id}}" @if($model->general_setting_id == $g->id) selected
                                        @endif>{{$g->phone}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error_text general_setting_id_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Kiểu</label>
                                <input type="text" name="type" id="type" class="form-control" value="{{$model->type}}">
                                <span class="text-danger error_text type_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Icon</label>
                                <input type="file" name="icon" class="form-control">
                                <span class="text-danger error_text icon_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Đường dẫn</label>
                                <input type="text" name="url" id="url" class="form-control" value="{{$model->url}}">
                                <span class="text-danger error_text url_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('footer.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
$(document).ready(function() {
    $(".btn-info").click(function(e) {
        e.preventDefault();
        var formData = new FormData($('form')[0]);
        let contentValue = $('#content').val();
        let content = contentValue.charAt(0).toUpperCase() + contentValue.slice(1);
        formData.set('content', content);
        $.ajax({
            url: "{{route('footer.saveEdit',['id'=>$model->id])}}",
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
                $('#realize').attr('href', data.url)
                $('#realize').text('Chân trang');
                $("#myModal").modal('show');
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
            placeholder: 'Select ' + idSelect,
            width: '100%'
        });
    })
});
</script>
@endsection