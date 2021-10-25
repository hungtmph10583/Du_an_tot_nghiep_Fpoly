@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('accessory.index')}}">Danh sách phụ kiện</a></li>
                        <li class="breadcrumb-item active">Sửa phụ kiện</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}" alt="phụ kiện này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="">Tên phụ kiện</label>
                                    <input type="text" name="name" class="form-control" value="{{$model->name}}" placeholder="Tên phụ kiện">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh phụ kiện</label>
                                    <input type="file" name="uploadfile" class="form-control">
                                    @error('uploadfile')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        @foreach($category as $c)
                                            @if($c->category_type_id == 2)
                                                <option value="{{$c->id}}" @if($model->category_id == $c->id) selected @endif>{{$c->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="text" name="quantity" class="form-control" value="{{$model->quantity}}" placeholder="Số lượng phụ kiện">
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
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
                                    <label for="">Giá bán</label>
                                    <input type="text" name="price" class="form-control" value="{{$model->price}}" placeholder="Giá phụ kiện">
                                    @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
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
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Giảm giá</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Kiểu giảm giá</option>
                                        @foreach($discountType as $dt)
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nhập giá trị</label>
                                    <input type="text" class="form-control" placeholder="Nhập giá trị giảm giá">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Giới hạn</label>
                                    <input type="text" class="form-control" placeholder="Số lượng sản phẩm giảm giá">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Mã giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Nhập mã giảm giá">
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
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Ngày Kết thúc</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Mô tả</label>
                                    <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder="Chi tiết giảm giá"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
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
                                            <td>{{$gl->image_url}}</td>
                                            <td>
                                                <img src="{{asset('storage/' . $gl->image_url)}}" width="80">
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
                                    <label for="">Chi tiết phụ kiện:</label>
                                    <textarea name="detail" class=form-control rows="10" placeholder="{{$model->detail}}">{{$model->detail}}</textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success ml-2">Lưu</button>
                                <a href="{{route('accessory.index')}}" class="btn btn-danger">Hủy</a>
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