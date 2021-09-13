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
<div class="alert alert-success" role="alert" style="display: none;">
</div>

<section class="content">
    <div class="container-fluid pb-1">
        <div class="card card-success card-outline">
            <div class="card-header">
                <form action="book.import" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file" />

                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
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
            </div>
            <div class="card-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
                                        <a href="{{route('book.add')}}" class="btn btn-primary">Thêm sách</a>
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
<link rel="stylesheet" href="{{ asset('custom-css/custom.css')}}">
<script src="{{ asset('custom-css/custom.js')}}"></script>
<script>
$(document).ready(function() {
    var table = $('.data-table').DataTable({
        responsive: true,
        processing: true,
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copyHtml5',
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                }
            },
            "colvis"
        ],
        columnDefs: [{
            targets: 0,
            visible: true
        }],
        language: {
            processing: "<img width='70' src='https://cdn.tgdd.vn//GameApp/-1//MemeCheems1-500x500.jpg'>",
        },
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
                searchable: false,
            },
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'image',
                name: 'image',
            },
            {
                data: 'cate_id',
                name: 'cate_id',
            },
            {
                data: 'country',
                name: 'country',
            },
            {
                data: 'price',
                name: 'price',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'quantity',
                name: 'quantity',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]

    });
    let column = table.column(0); // here is the index of the column, starts with 0
    column.visible(false); // this should be either true or false
    table.buttons().container().appendTo('.row .col-md-6:eq(0)');
    $('select').map(function(i, dom) {
        var idSelect = $(dom).attr('id');
        $('#' + idSelect).change(function() {
            table.draw();
        });
        $('#' + idSelect).select2({
            selectOnClose: true,
        });
    })
});
</script>
@endsection