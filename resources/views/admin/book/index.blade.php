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
                                    <option @if(isset($searchData['cate']) && $c->id == $searchData['cate']) selected
                                        @endif
                                        value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="">Thể loại</label>
                                <select class="form-control" name="genres" id="genres">
                                    <option value="">Lấy tất cả</option>
                                    @foreach($genres as $g)
                                    <option @if(isset($searchData['genres']) && $g->id == $searchData['genres'])
                                        selected
                                        @endif
                                        value="{{$g->id}}">{{$g->name}}</option>
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
                                    <option @if(isset($searchData['country']) && $c->id == $searchData['country'])
                                        selected
                                        @endif
                                        value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="">Trạng thái</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option @if(isset($searchData['status']) && 1==$searchData['status']) selected
                                        @endif value="1">Còn hàng</option>
                                    <option @if(isset($searchData['status']) && 2==$searchData['status']) selected
                                        @endif value="2">Hết hàng</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="">Thể loại</label>
                                <select class="form-control" name="author" id="author">
                                    <option value="">Lấy tất cả</option>
                                    @foreach($author as $a)
                                    <option @if(isset($searchData['author']) && $a->id == $searchData['author'])
                                        selected
                                        @endif
                                        value="{{$a->id}}">{{$a->name}}</option>
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
</script>
@endsection