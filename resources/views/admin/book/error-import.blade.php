@section('title', 'Thêm sách')
@extends('layouts.admin.main')
@section('content')
<!-- BEGIN: Subheader -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-secondary my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item">
                        <a class="card-title" href="{{route('book.index')}}">Danh sách sách</a>
                    </li>
                    <li class="breadcrumb-item active">Thêm sách</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- END: Subheader -->
<section class="content">
    <div class="container-fluid pb-1">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection