@extends('layouts.admin.main')
@section('content')
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
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" value="{{$model->name}}" placeholder="Tên sản phẩm">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh sản phẩm</label>
                                    <input type="file" name="uploadfile" class="form-control">
                                    @error('uploadfile')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        @foreach($category as $c)
                                        <option value="{{$c->id}}" @if($model->category_id == $c->id) selected @endif>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Giống loài</label>
                                    <select name="breed_id" class="form-control">
                                        @foreach($breed as $br)
                                        <option value="{{$br->id}}" @if($model->breed_id == $br->id) selected @endif>{{$br->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="text" name="quantity" class="form-control" value="{{$model->quantity}}" placeholder="Số lượng sản phẩm">
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Cân nặng</label>
                                    <input type="text" name="weight" class="form-control" value="{{$model->weight}} kg" placeholder="Cân nặng của thú cưng">
                                    @error('weight')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"> 
                                <div class="form-group">
                                    <label for="">Giá bán</label>
                                    <input type="text" name="price" class="form-control" value="{{$model->price}}" placeholder="Giá sản phẩm">
                                    @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6"> 
                                <div class="form-group">
                                    <label for="">Tuổi của thú cưng</label>
                                    <input type="text" name="age_id" class="form-control" value="{{$model->age_id}}" placeholder="Tuổi hiện tại của thú cưng">
                                    @error('age_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <div class="form-control">
                                        <input type="radio" name="status" value="1" id="stt1" @if($model->status === 1) checked @endif>
                                        <label for="stt1" class="mr-5">Còn hàng</label>
                                        <input type="radio" name="status" value="0" id="stt0" @if($model->status === 0) checked @endif>
                                        <label for="stt0">Hết hàng</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Giới tính</label>
                                    <div class="form-control">
                                        @foreach($gender as $gd)
                                        <input type="radio" name="gender_id" id="{{$gd->id}}" value="{{$gd->id}}" @if($model->gender_id == $gd->id) checked @endif>
                                        <label for="{{$gd->id}}" class="pr-4">{{$gd->gender}}</label>
                                        @endforeach
                                    </div>
                                    @error('gender')
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
                                            <button class="float-right btn btn-success add-img" type="button">Thêm ảnh</button>
                                        </th>
                                    </thead>
                                    <tbody id="gallery">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Chi tiết sản phẩm:</label>
                                    <textarea name="detail" class=form-control rows="10" placeholder="{{$model->detail}}">{{$model->detail}}</textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success ml-2">Lưu</button>
                                <a href="{{route('product.index')}}" class="btn btn-danger">Hủy</a>
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