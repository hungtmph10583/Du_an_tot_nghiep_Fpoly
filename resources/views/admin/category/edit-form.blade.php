@extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('category.index')}}">Danh sách danh
                            mục</a></li>
                    <li class="breadcrumb-item active">Sửa danh mục</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Ảnh danh mục</label>
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}"
                                    alt="Danh mục này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tên danh mục</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$model->name}}"
                                    placeholder="Tên danh mục">
                                <span class="text-danger error_text name_error"></span>
                            </div>
                            <input type="hidden" name="slug" id="slug" value="{{$model->slug}}">
                            <div class="form-group">
                                <label for="">Ảnh danh mục</label>
                                <input type="file" name="uploadfile" class="form-control">
                                <span class="text-danger error_text uploadfile_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Loại danh mục</label>
                                <select name="category_type_id" class="form-control">
                                    @foreach($categoryType as $type)
                                    <option value="{{$type->id}}" @if($model->category_type_id == $type->id) selected
                                        @endif>{{$type->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error_text category_type_id_error"></span>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Hiển thị ra slide</label>
                                        <div class="form-control">
                                            <label class="pr-2">
                                                <input type="radio" name="show_slide" value="1"
                                                    {{ ($model->show_slide == 1 ? 'checked' : '') }}> Hiển thị
                                            </label>
                                            <label class="pl-2">
                                                <input type="radio" name="show_slide" value="0"
                                                    {{ ($model->show_slide == 0 ? 'checked' : '') }}> Ẩn
                                            </label>
                                        </div>
                                        <span class="text-danger error_text show_slide_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('category.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script>
function slugify(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();
    // remove accents, swap ñ for n, etc
    var from = "ạảầấậẩẫăằắặẳẵãàáäâẹẻềếệểễẽèéëêìíịĩỉïîọỏõồốộổỗơờớợởỡõòóöôụủũưừứựửữùúüûñçỳýỵỷỹđ·/_,:;";
    var to = "aaaaaaaaaaaaaaaaaaeeeeeeeeeeeeiiiiiiiooooooooooooooooooouuuuuuuuuuuuuncyyyyyd------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes
    return str;
}
$(document).ready(function() {
    var name = $('#name');
    var slug = $('#slug');
    name.keyup(function() {
        slug.val(slugify(name.val()));
    });
});
$(".btn-info").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    let nameValue = $('#name').val();
    let name = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
    formData.set('name', name);
    formData.append('slug', $('input[name="slug"]').val())
    $.ajax({
        url: "{{ route('category.saveEdit',['id'=>$model->id]) }}",
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
    console.log(i)
    $('#' + idSelect).select2({
        placeholder: 'Select ' + idSelect
    });
})
</script>
@endsection