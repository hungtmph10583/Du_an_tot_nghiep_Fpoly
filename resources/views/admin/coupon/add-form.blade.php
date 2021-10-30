@extends('layouts.admin.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item"><a class="card-title" href="{{route('coupon.index')}}">Danh sách phiếu giảm giá</a></li>
                        <li class="breadcrumb-item active">Thêm phiếu giảm giá mới</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
            @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Thông tin phiếu giảm giá</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Loại giảm giá</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <select name="type" class="form-control" id="">
                                    <option value="">Chọn một</option>
                                        @foreach($couponType as $cpt)
                                        <option value="{{$cpt->id}}" @if($cpt->id == old('type')) selected @endif>{{$cpt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Mã giảm giá</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Mã giảm giá" name="code" value="{{old('code')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Sản phẩm</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <select name="product_id" class="form-control" id="">
                                        <option value="">Sản phẩm</option>
                                        @foreach($product as $p)
                                        <option value="{{$p->id}}" @if($p->id == old('product_id')) selected @endif>{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Thời gian</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="date" name="start_date" class="form-control" value="{{old('start_date')}}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="date" name="end_date" class="form-control" value="{{old('end_date')}}">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="checkbox" id="forever" name="forever" value="{{old('forever')}}">
                                            <label for="forever">Không thời hạn</label>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Giảm giá</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="text" name="discount" class="form-control" placeholder="Giảm giá" value="{{old('discount')}}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <select name="discount_type" class="form-control" id="">
                                            <option value="">Chọn một</option>
                                                @foreach($discountType as $dct)
                                                <option value="{{$dct->id}}" @if($dct->id == old('discount_type')) selected @endif>{{$dct->name}}</option>
                                                @endforeach
                                            </select>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Nội dung giảm giá</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <textarea name="details" id="" class="form-control" cols="30" rows="10" placeholder="Nội dung giảm giá"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 mt-2"><br>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-info">Lưu</button>
                                    <a href="{{route('coupon.index')}}" class="btn btn-danger">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card">
                    <div class="card-body">
                        <div class="card-title">Thông tin phiếu giảm giá</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Loại giảm giá</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <select name="type" class="form-control" id="">
                                        <option value="">Chọn một</option>
                                        @foreach($couponType as $cpt)
                                        <option value="{{$cpt->id}}" @if($cpt->id == old('type')) selected @endif>{{$cpt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Mã giảm giá</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Mã giảm giá" name="code">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Số lượng sản phẩm tối thiểu</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Số lượng sản phẩm tối thiểu">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Giảm giá</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control" placeholder="Giảm giá">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <select name="discount_type" class="form-control" id="">
                                                <option value="">Chọn một</option>
                                                @foreach($discountType as $dct)
                                                <option value="{{$dct->id}}" @if($dct->id == old('discount_type')) selected @endif>{{$dct->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Chiết khấu tối đa</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Chiết khấu tối đa">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Thời gian</label>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="date" name="start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="date" name="end_date" class="form-control">
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
                                    <a href="{{route('coupon.index')}}" class="btn btn-danger">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection