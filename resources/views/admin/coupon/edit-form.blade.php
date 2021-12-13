@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('coupon.index')}}">Danh sách phiếu
                            giảm giá</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa phiếu giảm giá</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
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
                    <div class="card-title">Thông tin phiếu giảm giá</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Loại giảm giá</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <select name="type" class="form-control" id="type">
                                    <option value=""></option>
                                    @foreach($couponType as $cpt)
                                    <option value="{{$cpt->id}}" @if($coupon->type == $cpt->id) selected
                                        @endif>{{$cpt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error_text type_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Mã giảm giá</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Mã giảm giá" name="code"
                                    value="{{$coupon->code}}">
                            </div>
                            <span class="text-danger error_text code_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Sản phẩm</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <select name="product_id[]" class="form-control" id="product" multiple>
                                    <option value=""></option>
                                    @foreach($product as $p)
                                    @if(!($p->discount || $p->coupon_id) || ($p->coupon_id == $coupon->id))
                                    <option @foreach($coupon->products as $pro)
                                        {{ ($p->id == $pro->id) ? 'selected="selected"' : '' }}
                                        @endforeach value="{{$p->id}}">{{$p->name}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error_text product_id_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Danh mục</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <select name="category_id[]" class="form-control" id="category" multiple>
                                    <option value=""></option>
                                    @foreach($category as $c)
                                    @if(!($c->coupon_id) || ($c->coupon_id == $coupon->id))
                                    <option @foreach($coupon->category as $cate)
                                        {{ ($c->id == $cate->id) ? 'selected="selected"' : '' }}
                                        @endforeach value="{{$c->id}}">{{$c->name}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error_text category_id_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Thời gian</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="datetime-local" name="start_date" id="start" class="form-control"
                                            value="{{\Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d\TH:i')}}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="datetime-local" name="end_date" id="end" class="form-control"
                                            value="{{\Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d\TH:i')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="checkbox" id="forever" name="forever" @if(!($coupon->start_date &&
                                        $coupon->end_date)) checked @endif>
                                        <label for="forever">Không thời hạn</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Giảm giá</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" id="discountPro" name="discount" class="form-control"
                                            placeholder="Giảm giá" value="{{$coupon->discount}}">
                                    </div>
                                    <span class="text-danger error_text discount_error"></span>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <select name="discount_type" class="form-control" id="discount">
                                            <option value="">Chọn một</option>
                                            @foreach($discountType as $dct)
                                            <option value="{{$dct->id}}" @if($coupon->discount_type == $dct->id)
                                                selected @endif>{{$dct->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger error_text discount_type_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('coupon.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js')}}"></script>
<script>
$(document).ready(function() {
    $(".btn-info").click(function(e) {
        e.preventDefault();
        var formData = new FormData($('form')[0]);
        if ($('#forever').is(':checked')) {
            formData.set('start_date', ' ');
            formData.set('end_date', ' ');
        }

        formData.set('start_date', dateTime($("#start").val()))
        formData.set('end_date', dateTime($("#end").val()))

        $.ajax({
            url: "{{ route('coupon.saveEdit',['id'=>$coupon->id]) }}",
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
                $('#realize').text('Giảm giá');
                $("#myModal").modal('show');
                if (data.status == 0) {
                    showErr = '<div class="alert alert-danger" role="alert" id="danger">';
                    $.each(data.error, function(key, value) {
                        showErr +=
                            '<span class="fas fa-times-circle text-danger mr-2"></span>' +
                            value[0] +
                            '<br>';
                        $('span.' + key.replace('.0', '') + '_error').text(value[
                            0]);
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
});
$('select').map(function(i, dom) {
    var idSelect = $(dom).attr('id');
    $('#' + idSelect).select2({
        placeholder: 'Select ' + idSelect
    });
})
</script>
@endsection