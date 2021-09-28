@extends('layouts.admin.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('product.index')}}">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active">Sửa sản phẩm</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" value="{{$model->name}}">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <select name="cate_id" class="form-control">
                                        @foreach($cates as $c)
                                        <option value="{{$c->id}}" @if($c->id == $model->cate_id) selected @endif>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Hãng xe</label>
                                    <select name="comp_id" class="form-control">
                                        @foreach($comp as $cp)
                                        <option value="{{$cp->id}}" @if($c->id == old('comp_id')) selected @endif>{{$cp->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Giá</label>
                                    <input type="number" name="price" class="form-control" value="{{$model->price}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="number" name="quantity" class="form-control" value="{{$model->quantity}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Phụ kiện</label><br>
                                    <div class="form-control">
                                            @foreach ($tags as $tag)
                                                <input type="checkbox" name="tag_id[]" id="{{$tag->id}}" value="{{$tag->id}}"
                                                    @foreach ($model->product_tag as $prt)
                                                    @if($prt->tag_id == $tag->id) checked @endif
                                                    @endforeach
                                                >
                                                <label class="pr-2" for="{{$tag->id}}">{{$tag->name}}</label>
                                            @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="add-product-preview-img">
                                    <img src="{{asset('storage/' . $model->image)}}" class="img-thumbnail">
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh sản phẩm</label>
                                    <input type="file" name="uploadfile" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="removeGalleryIds" value="">
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
                                                <button type="button" class="btn btn-danger" onclick="removeGalleryImg(this, {{$gl->id}})">Xóa</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Chi tiết sản phẩm:</label>
                                    <textarea name="detail" class=form-control  rows="10">{{$model->detail}}</textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="{{route('product.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('pagejs')
<script>
    $(document).ready(function(){
        $('.add-img').click(function(){
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
    function removeGalleryImg(el, galleryId = 0){
        $(el).parent().parent().remove();
        if(galleryId != 0){
            let removeIds = $(`[name="removeGalleryIds"]`).val();
            removeIds += `${galleryId}|`
            $(`[name="removeGalleryIds"]`).val(removeIds);
        }
    }  
    function loadFile(event, el_rowId) {
            var reader = new FileReader();
            var output = document.querySelector(`img[row_id="${el_rowId}"]`);
            reader.onload = function(){
                output.src = reader.result;
            };
            if(event.target.files[0] == undefined){
                output.src = "";
                return false;
            }else {
                reader.readAsDataURL(event.target.files[0]);
            }
        }; 
</script>

@endsection