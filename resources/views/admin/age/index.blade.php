@section('title', 'Danh sách tuổi')
@extends('layouts.admin.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách tuổi</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@include('layouts.admin.message')
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
                                    <th>Tuổi</th>
                                    <th>Sản phẩm</th>
                                    <th><a href="{{route('age.add')}}" class="btn btn-outline-info float-right">Thêm
                                            tuổi</a></th>
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
                    if ('{{$admin}}') {
                        if (allId == '') {
                            $('.modal-body').html(
                                `<div class="alert alert-danger" role="alert">
                        <span class="fas fa-times-circle text-danger mr-2">
                        Hãy chọn danh mục để xóa
                        </span></div>`);

                            $('#realize').click(function(e) {
                                // ngăn quá trình thực thi nhiều lần modal bootstrap
                                $("#realize").unbind('click');
                                $('#myModal').modal('toggle');
                            })
                        } else {
                            $('.modal-body').html(
                                `<div class="alert alert-success" role="alert">
                        <span class="fas fa-check-circle text-success mr-2">
                        Thực hiện xóa dữ liệu ( Lưu ý : sau khi khối phục dữ liệu tất cả những dữ liệu liên quan sẽ được xóa )
                        </span></div>`);

                            $('#realize').click(function(e) {
                                $("#realize").unbind('click');
                                $('#myModal').modal('toggle');
                                deleteMul('{{route("age.removeMul")}}', allId);
                                table.ajax.reload();
                            })
                        }
                    } else {
                        $('.modal-body').html(
                            `<div class="alert alert-danger" role="alert">
                        <span class="fas fa-times-circle text-danger mr-2">
                        Bạn không đủ quyền để dùng chức năng này
                        </span></div>`);
                        $('#realize').css('display', 'none')
                        $('#cancel').click(function(e) {
                            $("#cancel").unbind('click');
                            $('#myModal').modal('toggle');
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
            url: "{{ route('age.filter') }}",
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
                data: 'age',
                name: 'age',
            },
            {
                data: 'product',
                name: 'product',
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

    $(document).on("click", "#undoIndex", function() {
        id = $('#undoIndex').data('id');
        var url = '{{route("age.restore",":id")}}';
        url = url.replace(':id', id);
        undoIndex(url, id)
        table.ajax.reload();
    })
});
</script>
@endsection