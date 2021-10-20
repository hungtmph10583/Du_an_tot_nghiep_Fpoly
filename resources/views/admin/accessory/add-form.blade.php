@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('accessory.index')}}">Danh sách phụ kiện</a></li>
                        <li class="breadcrumb-item active">Thêm phụ kiện</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid pb-1">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tên phụ kiện</label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Tên phụ kiện">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Ảnh phụ kiện</label>
                                    <input type="file" name="uploadfile" class="form-control">
                                    @error('uploadfile')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"> 
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        @foreach($category as $c)
                                            @if($c->genre_type == 1)
                                                <option value="{{$c->id}}" @if($c->id == old('category_id')) selected @endif>{{$c->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <div class="form-control">
                                        <input type="radio" name="status" value="1" id="stt1" checked>
                                        <label for="stt1" class="mr-5">Còn hàng</label>
                                        <input type="radio" name="status" value="0" id="stt0">
                                        <label for="stt0">Hết hàng</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="text" name="quantity" class="form-control" value="{{old('quantity')}}" placeholder="Số lượng phụ kiện">
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6"> 
                                <div class="form-group">
                                    <label for="">Giá bán</label>
                                    <input type="text" name="price" class="form-control" value="{{old('price')}}" placeholder="Giá bán">
                                    @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-stripped">
                                    <thead>
                                        <th>File</th>
                                        <th>Thumbnail</th>
                                        <th>
                                            <button class="btn btn-success add-img float-right" type="button">Thêm ảnh</button>
                                        </th>
                                    </thead>
                                    <tbody id="gallery">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Chi tiết phụ kiện:</label>
                                    <textarea name="detail" class=form-control  rows="10"></textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success ml-2">Lưu</button>
                                <a href="{{route('accessory.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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