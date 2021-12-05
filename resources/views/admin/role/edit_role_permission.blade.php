@section('title', 'Add Role')
@extends('layouts.admin.main')
@section('content')
<div class="container-fluid pt-4">
    <div id="alon"></div>
    <form action="" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Edit Role</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Name Role</label>
                            <input type="text" name="name" class="form-control" value="{{$role->name}}" placeholder="Name role">
                            @error('name') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('role.index')}}" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-success">Edit Role</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Permissions</div>
                    <div class="card-body" id="card_body_permission">
                        @error('permissions_id') <div class="text-danger mb-2">{{ $message }}</div> @enderror
                        @foreach($permissions as $permission)
                            <div class="form-group">
                                <input type="checkbox" name="permissions_id[]" id="{{$permission->id}}" value="{{$permission->id}}" 
                                    @foreach($role_has_permission as $mhr)
                                        @if($mhr->permission_id == $permission->id)
                                            checked
                                        @endif
                                    @endforeach
                                >
                                <label for="{{$permission->id}}">{{$permission->name}}</label>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection