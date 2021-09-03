@section('title', 'Sửa sách')
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
                    <li class="breadcrumb-item active">Sửa sách</li>
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
                                <input type="text" name="name" class="form-control" value="{{old('name',$model->name)}}"
                                    placeholder="Tên sách">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label>Danh mục</label>
                                    <select class="custom-select" name="cate_id" id="cate_id">
                                        <option value="">Chọn danh mục</option>
                                        @foreach($category as $c)
                                        <option @if($c->id == $model->cate_id) selected @elseif(old('cate_id') ==
                                            $c->id) selected @else : '' @endif
                                            value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('cate_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label>Quốc gia</label>
                                    <select class="custom-select" name="country_id" id="country_id">
                                        <option value="">Chọn quốc gia</option>
                                        @foreach($country as $c)
                                        <option @if($c->id == $model->country_id) selected @elseif(old('country_id') ==
                                            $c->id) selected @else : '' @endif
                                            value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="">Thể loại</label>
                                    @foreach($genres as $g)
                                    <div class="form-check" style="margin-left:5px;">
                                        <input @foreach($model->genres as $ta)
                                        @if($g->id == $ta->id) checked @elseif(old('genres') ==
                                        $ta->id) checked @else '' @endif
                                        @endforeach type="checkbox" name="genres[]" id="genres" class="form-check-input"
                                        value="{{$g->id}}">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$g->name}}
                                        </label>
                                    </div>
                                    @endforeach
                                    @error('genres')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="">Tác giả</label>
                                    @foreach($author as $a)
                                    <div class="form-check" style="margin-left:5px;">
                                        <input @foreach($model->authors as $ta)
                                        {{ ($a->id == $ta->id) ? 'checked="checked"' : '' }}
                                        @endforeach type="checkbox" name="author[]" id="author" class="form-check-input"
                                        value="{{$a->id}}">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$a->name}}
                                        </label>
                                    </div>
                                    @endforeach
                                    @error('author')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div id="cc" style="display: none">
                                <img class="add-product-preview-img" id="blah" src="{{asset('storage/'.$model->image)}}"
                                    alt="your image" />
                            </div>
                            <div class="form-group">
                                <label for="">Ảnh đại diện</label>
                                <input type="file" name="image" id="imgInp" class="form-control">
                                @error('image')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Giá</label>
                                <input type="number" name="price" class="form-control"
                                    value="{{old('price',$model->price)}}">
                                @error('price')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="number" name="quantity" class="form-control"
                                    value="{{old('quantity',$model->quantity)}}">
                                @error('quantity')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="custom-select" name="status" id="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option @if($model->status == '0') selected @elseif(old('status') ==
                                        '0') selected @else '' @endif value="0">Hết hàng
                                    </option>
                                    <option @if($model->status == '1') selected @elseif(old('status') ==
                                        '1') selected @else '' @endif value="1">Còn hàng
                                    </option>
                                    <option @if($model->status == '3') selected @elseif(old('status') ==
                                        '3') selected @else '' @endif value="3">Sắp ra mắt
                                    </option>
                                </select>
                                @error('status')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-stripped">
                                <thead>
                                    <th>File</th>
                                    <th>Thumbnail</th>
                                    <th>
                                        <button class="btn btn-success add-img" type="button">Thêm ảnh</button>
                                    </th>
                                </thead>
                                <tbody id="gallery">
                                    @foreach ($model->galleries as $gl)
                                    <tr id="{{$gl->id}}">
                                        <td>{{$gl->url}}</td>
                                        <td>
                                            <img src="{{asset('storage/' . $gl->url)}}" width="80">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger"
                                                onclick="removeGalleryImg(this, {{$gl->id}})">Xóa</button>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label>Chi tiết</label>
                                <textarea class="form-control" id="detail"
                                    name="detail">{{old('detail',$model->detail)}}</textarea>
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
                            <img row_id="${rowId}" src="" width="80">
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="removeImg(this)">Xóa</button>
                        </td>
                    </tr>
                `);
    })
});

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