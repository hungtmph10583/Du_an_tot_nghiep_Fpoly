@section('title', 'Edit Role User')
@extends('layouts.admin.main')
@section('content')
<div class="container-fluid pt-4">
    <form action="" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Roles</div>
                    <div class="card-body">
                        <div class="form-group">
                            <select name="role_id" class="form-control">
                                <option value="">Chọn quyền hạn</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            @error('role_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('role.index')}}" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-success">Add Roles</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">User name</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="user_id" class="form-control" value="{{$user->name}}" disabled>
                        </div> 
                        @error('user_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection