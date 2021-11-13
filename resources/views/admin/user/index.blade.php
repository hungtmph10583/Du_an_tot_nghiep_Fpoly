@section('title', 'Danh sách tài khoản')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách tài khoản</li>
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
            <div class="card-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="row">
                    <div style="width: 100%;">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" style="width:100%">
                                <thead>
                                    <th>STT</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>
                                        @hasanyrole('admin|manage')
                                        <a href="{{route('user.add')}}" class="btn btn-outline-info float-right">Thêm
                                            tài
                                            khoản</a>
                                        @else
                                        <a href="#" onclick="alert('Bạn không được cấp quyền để tạo tài khoản?')"
                                            class="btn-outline-info float-right">Thêm tài khoản</a>
                                        @endhasrole
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
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
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
                charset: 'utf-8',
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
                orientation: 'portrait',
                pageSize: 'LEGAL',
                orientation: 'landscape',
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                }
            }, {
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
            url: "{{ route('user.filter') }}",
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
    $('select').map(function(i, dom) {
        var idSelect = $(dom).attr('id');
        $('#' + idSelect).change(function() {
            table.draw();
        });
        $('#' + idSelect).select2({});
    })
});
</script>
@endsection