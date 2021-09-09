@section('title', 'Danh sách sách')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách sách</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <div class="card card-success card-outline">
            <div class="card-header">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-6">
                            <div class="">
                                <label for="">Danh mục</label>
                                <select class="form-control" name="cate" id="cate">
                                    <option value="">Lấy tất cả</option>
                                    @foreach($category as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="">Thể loại</label>
                                <select class="form-control" name="genres" id="genres">
                                    <option value="">Lấy tất cả</option>
                                    @foreach($genres as $g)
                                    <option value="{{$g->id}}">{{$g->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="">
                                <label for="">Quốc gia</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="">Lấy tất cả</option>
                                    @foreach($country as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="">Trạng thái</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="1">Còn hàng</option>
                                    <option value="2">Hết hàng</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="">Thể loại</label>
                                <select class="form-control" name="author" id="author">
                                    <option value="">Lấy tất cả</option>
                                    @foreach($author as $a)
                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div style="width: 100%;">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" style="width:100%">
                                <thead>
                                    <th>STT</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Country</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th>
                                        <a href="{{route('book.add')}}" class="btn btn-primary">Thêm tài khoản</a>
                                    </th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<style>
.select2-selection__rendered {
    line-height: 31px !important;
}

.select2-container .select2-selection--single {
    height: 40px !important;
}

.select2-selection__arrow {
    height: 40px !important;
}
</style>
<script>
$(document).ready(function() {
    var table = $('.data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('book.filter') }}",
            data: function(d) {
                d.cate = $('#cate').val();
                d.status = $('#status').val();
                d.country = $('#country').val();
                d.author = $('#author').val();
                d.genres = $('#genres').val();
                d.search = $('input[type="search"]').val();
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'image',
                name: 'image'
            },
            {
                data: 'cate_id',
                name: 'cate_id'
            },
            {
                data: 'country',
                name: 'country'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]

    });

    $('#status').change(function() {
        table.draw();
    });

    $('#cate').change(function() {
        table.draw();
    });

    $('#country').change(function() {
        table.draw();
    });

    $('#genres').change(function() {
        table.draw();
    });

    $('#author').change(function() {
        table.draw();
    });
});

$('#genres').select2({
    selectOnClose: true,
});

$('#status').select2({
    selectOnClose: true
});

$('#cate').select2({
    selectOnClose: true
});

$('#country').select2({
    selectOnClose: true
});

$('#author').select2({
    selectOnClose: true
});
</script>
@endsection