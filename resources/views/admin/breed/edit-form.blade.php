@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('breed.index')}}">Danh sách giống
                            loài</a></li>
                    <li class="breadcrumb-item active">Sửa giống loài</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
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
                                <label for="">Ảnh đại diện giống loài</label>
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}"
                                    alt="Giống loài này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tên giống loài</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$model->name}}"
                                    placeholder="Tên giống loài">
                                <span class="text-danger error_text name_error"></span>
                            </div>
                            <input type="hidden" name="slug" id="slug" value="{{$model->slug}}">
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select name="category_id" class="form-control">
                                    @foreach($category as $c)
                                    @if($c->genre_type == 0)
                                    <option value="{{$c->id}}" @if($c->id == old('category_id')) selected
                                        @endif>{{$c->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span class="text-danger error_text category_id_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Ảnh</label>
                                <div class="form-control">
                                    <input type="file" name="uploadfile" id="">
                                </div>
                                <span class="text-danger error_text uploadfile_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-control">
                                    <label class="pr-2">
                                        <input type="radio" name="status" value="1"
                                            {{ ($model->status == 1 ? 'checked' : '') }}> Hiển thị
                                    </label>
                                    <label class="pl-2">
                                        <input type="radio" name="status" value="0"
                                            {{ ($model->status == 0 ? 'checked' : '') }}> Ẩn
                                    </label>
                                </div>
                                <span class="text-danger error_text status_error"></span>
                            </div><br>
                            <div class="text-left">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('breed.index')}}" class="btn btn-danger">Hủy</a>
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
        url: "{{ route('breed.saveEdit', ['id' => $model->id]) }}",
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