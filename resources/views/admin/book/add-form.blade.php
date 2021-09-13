@section('title', 'Thêm sách')
@extends('layouts.admin.main')
@section('content')
<!-- BEGIN: Subheader -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item">
                        <a class="card-title" href="{{route('book.index')}}">Danh sách sách</a>
                    </li>
                    <li class="breadcrumb-item active">Thêm sách</li>
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
                                <input type="text" name="name" class="form-control" placeholder="Tên sách">
                                <span class="text-danger error_text name_error"></span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="">
                                        <label>Danh mục</label>
                                        <select class="form-control" name="cate_id" id="cate">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($category as $c)
                                            <option value="{{$c->id}}">
                                                {{$c->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error_text cate_id_error"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="">
                                        <label>Quốc gia</label>
                                        <select class="form-control" name="country_id" id="country">
                                            <option value="">Chọn quốc gia</option>
                                            @foreach($country as $c)
                                            <option value="{{$c->id}}">
                                                {{$c->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error_text country_id_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="">Thể loại</label>
                                    <select class="form-control" name="genres[]" id="genres" multiple>
                                        @foreach($genres as $g)
                                        <option value="{{$g->id}}">{{$g->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error_text genres_error"></span>
                                </div>
                                <div class="col">
                                    <label for="">Tác giả</label>
                                    <select class="form-control" name="author[]" id="author" multiple>
                                        @foreach($author as $a)
                                        <option value="{{$a->id}}">{{$a->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error_text author_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="0">Hết hàng</option>
                                    <option value="1">Còn hàng</option>
                                    <option value="3">Sắp ra mắt</option>
                                </select>
                                <span class="text-danger error_text status_error"></span>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ảnh đại diện</label>
                                <input type="file" name="image" id="imgInp" class="form-control"
                                    onchange="loadFile(event)">
                                <span class="text-danger error_text image_error"></span>
                            </div>
                            <div class="form-group col-md-6" id="image-show">
                                <img id="images" width="70" alt="">
                            </div>
                            <div class="form-group">
                                <label for="">Giá</label>
                                <input type="number" name="price" placeholder="Giá sách" class="form-control">
                                <span class="text-danger error_text price_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="number" name="quantity" placeholder="Số lượng sách" class="form-control">
                                <span class="text-danger error_text quantity_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-stripped">
                                <thead>
                                    <th>File</th>
                                    <th>Thumbnail</th>
                                    <th>
                                        <button class="btn btn-primary add-img" type="button">Thêm ảnh</button>
                                    </th>
                                </thead>
                                <tbody id="gallery">

                                </tbody>
                            </table>
                            <span class="text-danger error_text galleries_error"></span>
                            <div class="form-group">
                                <label>Chi tiết</label>
                                <textarea class="form-control" name="detail"></textarea>
                            </div>
                        </div>
                        <div class="text-right pl-2">
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{route('book.index')}}" class="btn btn-danger">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('custom-css/custom.css')}}">
<script src="{{ asset('custom-css/custom.js')}}"></script>
<script>
$(document).ready(function() {

    tinymce.init({
        selector: 'textarea', // change this value according to your HTML
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        },
        width: 700,
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link image | print preview media fullpage | ' +
            'forecolor backcolor emoticons | help',
        menu: {
            favs: {
                title: 'My Favorites',
                items: 'code visualaid | searchreplace | emoticons'
            }
        },
        menubar: 'favs file edit view insert format tools table',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        relative_urls: false,
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', "{{route('book.upload')}}");
            var token = '{{csrf_token()}}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
    });
    $('.add-img').click(function() {
        var rowId = Date.now();
        $('#gallery').append(`
                    <tr id="${rowId}">
                        <td>
                            <div class="form-group">
                                <input row_id="${rowId}" type="file" name="galleries[]" class="form-control" onchange="loadFiles(event, ${rowId})">
                            </div>
                        </td>
                        <td>
                            <img row_id="${rowId}" src=""  width="80">
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="removeImg(this)">Xóa</button>
                        </td>
                    </tr>
                `);
    })
});



$(".btn-success").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    $.ajax({
        url: "{{ route('book.saveAdd') }}",
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
            console.log(data);
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
        selectOnClose: true,
    });
})
</script>
@endsection