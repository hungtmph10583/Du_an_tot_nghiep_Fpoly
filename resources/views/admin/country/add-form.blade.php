@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('country.index')}}">Danh sách
                            quốc gia</a>
                    </li>
                    <li class="breadcrumb-item active">Tạo quốc gia</li>
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
                                <label for="">Code</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="Ký hiệu">
                                <span class="text-danger error_text code_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tên quốc gia</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Tên quốc gia">
                                <span class="text-danger error_text name_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-control">
                                    <label class="pr-2">
                                        <input type="radio" name="status" value="1" checked> Hiển thị
                                    </label>
                                    <label class="pl-2">
                                        <input type="radio" name="status" value="0"> Ẩn
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('country.index')}}" class="btn btn-danger">Hủy</a>
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
        let nameValue = $('#name').val();
        let codeValue = $('#code').val();
        let name = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
        formData.set('code', codeValue.toUpperCase());
        formData.set('name', name);
        $.ajax({
            url: "{{route('country.saveAdd')}}",
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
                $('#realize').text('Quốc gia');
                if (data.status == 0) {
                    $("#myModal").modal('show');
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
                    $(document).find('input.form-control').val(null);
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
});
</script>
@endsection