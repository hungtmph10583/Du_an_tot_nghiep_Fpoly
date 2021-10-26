@extends('layouts.admin.main')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách danh mục</li>
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
                <!-- <form action="" method="get">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Tên danh mục</label>
                                <input class="form-control" placeholder="Search" type="text" name="keyword"
                                    @isset($searchData['keyword']) value="{{$searchData['keyword']}}" @endisset>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Sắp xếp theo</label>
                                <select class="form-control" name="order_by">
                                    <option value="0">Mặc định</option>
                                    <option @if(isset($searchData['order_by']) && $searchData['order_by']==1) selected
                                        @endif value="1">Thú Cưng</option>
                                    <option @if(isset($searchData['order_by']) && $searchData['order_by']==2) selected
                                        @endif value="2">Phụ kiện</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info mt-2">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </form> -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="row">
                    <table class="table table-striped data-table">
                        <thead>
                            <th>STT</th>
                            <th>Tên giống loài</th>
                            <th class="text-center">Tên danh mục</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Tác vụ</th>
                            <th><a href="{{route('breed.add')}}" class="btn btn-outline-info float-right">Thêm giống
                                    loài</a></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css')}}">
<script src="{{ asset('admin-theme/custom-js/custom.js')}}"></script>
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

                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {

                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {

                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'portrait',
                pageSize: 'LEGAL',
                orientation: 'landscape',
                exportOptions: {

                    columns: ':visible'
                }
            }, {
                extend: 'print',
                exportOptions: {

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
            url: "{{ route('breed.filter') }}",
            data: function(d) {
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
                data: 'category_id',
                name: 'category_id',
            },
            {
                data: 'status',
                name: 'status',
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
    // $('select').map(function(i, dom) {
    //     var idSelect = $(dom).attr('id');
    //     $('#' + idSelect).change(function() {
    //         table.draw();
    //     });
    //     // $('#' + idSelect).select2({});

    // })
});
</script>
@endsection