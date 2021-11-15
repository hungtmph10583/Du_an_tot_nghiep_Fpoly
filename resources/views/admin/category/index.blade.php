@section('title', 'Danh sách danh mục')
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</a>
                <a type="button" class="btn btn-primary" id="cate" data-success="start">Thực hiện</a>
            </div>
        </div>
    </div>
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <div class="card">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="card-body">
                <div class="alert alert-success" role="alert" style="display: none;">

                </div>
                @if(session('BadState'))
                <div class="alert alert-danger" role="alert">
                    {{session('BadState')}}
                </div>
                @endif
                <div class="row">
                    <div style="width: 100%;">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" style="width:100%">
                                <thead>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Tên danh mục</th>
                                    <th class="text-center">Kiểu danh mục</th>
                                    <th><a href="{{route('category.add')}}"
                                            class="btn btn-outline-info float-right">Thêm danh
                                            mục</a></th>
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
                text: 'Reload',
                action: function(e) {
                    table.ajax.reload();
                }
            },
            {
                text: 'Delete',
                action: function(e) {
                    e.preventDefault();
                    $("#myModal").modal('show');
                    var allId = [];
                    $('input:checkbox[name=checkPro]:checked').each(function() {
                        allId.push($(this).val());
                    })
                    if (allId == '') {
                        $('.modal-body').html(
                            `<div class="alert alert-danger" role="alert">
                        <span class="fas fa-times-circle text-danger mr-2">
                        Hãy chọn danh mục để xóa
                        </span></div>`);

                        $('#cate').click(function(e) {
                            $('#myModal').modal('toggle');
                        })
                    } else {
                        $('.modal-body').html(
                            `<div class="alert alert-success" role="alert">
                        <span class="fas fa-check-circle text-success mr-2">
                        Thực hiện xóa dữ liệu ( Lưu ý : sau khi khối phục dữ liệu tất cả những dữ liệu liên quan sẽ được xóa )
                        </span></div>`);

                        $('#cate').click(function(e) {
                            $('#myModal').modal('toggle');
                            deleteMul('{{route("category.removeMul")}}', allId);
                            table.ajax.reload();
                        })
                    }
                }
            },
            {
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
            "orderable": false,
            "targets": 0
        }],
        "order": [],
        language: {
            processing: "<img width='70' src='{{asset('storage/uploads/loading/Dancing_kitty.gif')}}'>",
        },
        serverSide: true,
        ajax: {
            url: "{{ route('category.filter') }}",
            data: function(d) {
                d.search = $('input[type="search"]').val();
            },
        },
        columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
            },
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'category_type_id',
                name: 'category_type_id',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    table.buttons().container().appendTo('.row .col-md-6:eq(0)');

    $('select').map(function(i, dom) {
        var idSelect = $(dom).attr('id');
        $('#' + idSelect).change(function() {
            table.draw();
        });
    })

    $(document).on("click", "#undoIndex", function() {
        undoIndex($('#undoIndex').data('id'))
        table.ajax.reload();
    })
});
</script>
@endsection