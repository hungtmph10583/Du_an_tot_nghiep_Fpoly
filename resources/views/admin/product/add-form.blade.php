@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('product.index')}}">Danh sách sản
                            phẩm</a></li>
                    <li class="breadcrumb-item active">Thêm sản phẩm</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}"
                                    placeholder="Tên sản phẩm">
                                <span class="text-danger error_text name_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ảnh sản phẩm</label>
                                <input type="file" name="uploadfile" class="form-control">
                                <span class="text-danger error_text uploadfile_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select name="category_id" class="form-control">
                                    @foreach($category as $c)
                                    @if($c->categoryType->id === 1)
                                    <option value="{{$c->id}}" @if($c->id == old('category_id')) selected
                                        @endif>{{$c->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span class="text-danger error_text category_id_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Giống loài</label>
                                <select name="breed_id" class="form-control">
                                    @foreach($breed as $br)
                                    <option value="{{$br->id}}">{{$br->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error_text breed_id_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Giá bán</label>
                                    <input type="text" name="price" class="form-control" placeholder="Giá bán">
                                    <span class="text-danger error_text price_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Số lượng sản phẩm</label>
                                    <input type="text" name="quantity" class="form-control"
                                        placeholder="Số lượng sản phẩm">
                                    <span class="text-danger error_text quantity_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <select name="status" id="" class="form-control" id="status">
                                        <option value="1">Còn hàng</option>
                                        <option value="0">Hết hàng</option>
                                    </select>
                                    <span class="text-danger error_text status_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Giới tính</label>
                                    <select name="gender_id" id="gender" class="form-control">
                                        @foreach($gender as $gd)
                                        <option value="{{$gd->id}}">{{$gd->gender}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error_text gender_id_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Cân nặng của thú cưng</label>
                                    <input type="text" name="weight" class="form-control" placeholder="Kg">
                                    <span class="text-danger error_text gender_id_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tuổi</label>
                                    <select name="age_id" class="form-control" id="age">
                                        <option value="">Tuổi của thú cưng</option>
                                        @foreach($age as $ag)
                                        <option value="{{$ag->id}}">{{$ag->age}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error_text age_id_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Giảm giá</label>
                                    <select name="counpon_id" id="counpon" class="form-control">
                                        <option value="">Kiểu giảm giá</option>
                                        @foreach($discountType as $dt)
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error_text counpon_id_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nhập giá trị</label>
                                    <input type="text" name="discount" class="form-control"
                                        placeholder="Nhập giá trị giảm giá">
                                    <span class="text-danger error_text discount_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Giới hạn</label>
                                    <input type="text" name="quantity_counpon" class="form-control"
                                        placeholder="Số lượng sản phẩm giảm giá">
                                    <span class="text-danger error_text quantity_counpon_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Mã giảm giá</label>
                                    <input type="text" name="code" class="form-control" placeholder="Nhập mã giảm giá">
                                    <span class="text-danger error_text code_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="" class="">Tạo mã tự động</label>
                                <div class="text-left">
                                    <button class="btn btn-outline-info">Auto</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Ngày bắt đầu</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Ngày Kết thúc</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Mô tả</label>
                                    <textarea name="description" id="" cols="30" rows="4" class="form-control"
                                        placeholder="Chi tiết giảm giá"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-stripped">
                                    <thead>
                                        <th>File</th>
                                        <th>Thumbnail</th>
                                        <th>
                                            <button class="btn btn-success add-img float-right" type="button">Thêm
                                                ảnh</button>
                                        </th>
                                    </thead>
                                    <tbody id="gallery">

                                    </tbody>
                                </table>
                                <span class="text-danger error_text galleries_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Chi tiết sản phẩm:</label>
                                <textarea name="description" class=form-control rows="10"></textarea>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success ml-2">Lưu</button>
                            <a href="{{route('product.index')}}" class="btn btn-danger">Hủy</a>
                        </div>
                    </div>
                </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<script>
$(document).ready(function() {
    $('.add-img').click(function() {
        var rowId = Date.now();
        $('#gallery').append(`
                <tr id="${rowId}">
                    <td>
                        <div class="form-group">
                            <input row_id="${rowId}" type="file" name="galleries[]" class="form-control" onchange="loadFile(event, ${rowId})">
                        </div>
                    </td>
                    <td>
                        <img row_id="${rowId}" src="" width="80">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeGalleryImg(this)">Xóa</button>
                    </td>
                </tr>
            `);
    })
})

function removeGalleryImg(el, galleryId = 0) {
    $(el).parent().parent().remove();
    if (galleryId != 0) {
        let removeIds = $(`[name="removeGalleryIds"]`).val();
        removeIds += `${galleryId}|`
        $(`[name="removeGalleryIds"]`).val(removeIds);
    }
}

function loadFile(event, el_rowId) {
    var reader = new FileReader();
    var output = document.querySelector(`img[row_id="${el_rowId}"]`);
    reader.onload = function() {
        output.src = reader.result;
    };
    if (event.target.files[0] == undefined) {
        output.src = "";
        return false;
    } else {
        reader.readAsDataURL(event.target.files[0]);
    }
};
</script>
@endsection