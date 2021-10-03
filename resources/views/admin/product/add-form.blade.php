@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('product.index')}}">Danh sách sản phẩm</a></li>
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
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Tên sản phẩm">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Ảnh sản phẩm</label>
                                    <input type="file" name="uploadfile" class="form-control">
                                    @error('uploadfile')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3"> 
                                <div class="form-group">
                                    <label for="">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        @foreach($category as $c)
                                        <option value="{{$c->id}}" @if($c->id == old('cate_id')) selected @endif>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3"> 
                                <div class="form-group">
                                    <label for="">Giống loài</label>
                                    <select name="breed_id" class="form-control">
                                        @foreach($breed as $br)
                                        <option value="{{$br->id}}" @if($c->id == old('br_id')) selected @endif>{{$br->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <div class="form-control">
                                        <input type="radio" name="status" value="1" id="stt1" checked>
                                        <label for="stt1" class="mr-5">Hoạt động</label>
                                        <input type="radio" name="status" value="0" id="stt0">
                                        <label for="stt0">Không hoạt động</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Số lượng</label>
                                    <input type="text" name="quantity" class="form-control" value="{{old('quantity')}}" placeholder="Số lượng sản phẩm">
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm"> 
                                <div class="form-group">
                                    <label for="">Giá</label>
                                    <input type="text" name="price" class="form-control" value="{{old('price')}}" placeholder="Giá sản phẩm">
                                    @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="">Giới tính</label>
                                    <div class="form-control">
                                        @foreach($gender as $gd)
                                        <input type="radio" name="gender_id" id="{{$gd->id}}" value="{{$gd->id}}" @if($c->id == old('gd_id')) checked @endif checked>
                                        <label for="{{$gd->id}}" class="pr-4">{{$gd->gender}}</label>
                                        @endforeach
                                    </div>
                                    @error('gender')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="">Cân nặng</label>
                                    <input type="text" name="weight" class="form-control" value="{{old('weight')}}" placeholder="Cân nặng của thú cưng">
                                    @error('weight')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">

                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-12">
                                <table class="table table-stripped">
                                    <thead>
                                        <th>File</th>
                                        <th>Thumbnail</th>
                                        <th>
                                            <button class="btn btn-success add-img" type="button">Thêm ảnh</button>
                                        </th>
                                    </thead>
                                    <tbody id="gallery">
                                        
                                    </tbody>
                                </table>
                            </div> -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Chi tiết sản phẩm:</label>
                                    <textarea name="detail" class=form-control  rows="10"></textarea>
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
    <!-- <script>
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
                            <button class="btn btn-danger" onclick="removeImg(this)">Xóa</button>
                        </td>
                    </tr>
                `);
            })
        })
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
        function removeTag(el){
            $(el).parent().parent().remove();
        }
    </script> -->
@endsection