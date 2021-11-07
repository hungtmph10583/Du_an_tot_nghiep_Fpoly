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
                    <li class="breadcrumb-item active">Thêm phiếu giảm giá mới</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

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
                                    <option value="">Chọn một</option>
                                    @foreach($couponType as $cpt)
                                    <option value="{{$cpt->id}}">{{$cpt->name}}</option>
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
                                <input type="text" id="code" class="form-control" placeholder="Mã giảm giá" name="code">
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
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error_text product_id_error"></span>
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
                                        <input type="date" id="start" name="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="date" id="start" name="end_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="checkbox" id="forever" name="forever" value="{{old('forever')}}">
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
                                        <input type="text" name="discount" class="form-control" placeholder="Giảm giá">
                                    </div>
                                    <span class="text-danger error_text discount_error"></span>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <select name="discount_type" class="form-control" id="discount">
                                            <option value=""></option>
                                            @foreach($discountType as $dct)
                                            <option value="{{$dct->id}}">{{$dct->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger error_text discount_type_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Nội dung giảm giá</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <textarea name="details" id="" class="form-control" cols="30" rows="10"
                                    placeholder="Nội dung giảm giá"></textarea>
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
<script>
$(".btn-info").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    $('#forever').click(function(e) {
        if ($(this).is(':checked')) {
            formData.set('start_date', '');
            formData.set('end_date', '');
        }
    })
    $.ajax({
        url: "{{ route('coupon.saveAdd') }}",
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
            if (data.status == 0) {
                $.each(data.error, function(key, value) {
                    $('span.' + key + '_error').text(value[0]);
                });
            } else {
                window.location.href = data.url;
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