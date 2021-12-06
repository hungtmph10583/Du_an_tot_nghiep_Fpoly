@section('title', 'Tài khoản')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/customer.css')}}">
@endsection
	<!-- content -->
<div class="section-mt"></div>
<section class="custommer">
    <div class="customer-container">
        <div class="title">
            <h1>Thông tin cá nhân</h1>
            <span>Cập nhật các thông tin cá nhân cơ bản giúp cho việc liên lạc và trải nghiệm dễ dàng hơn</span>
        </div>
        <div class="information-customer">
            <form action="" method="POST" enctype="multipart/form-data">
				@csrf
                <div class="avatar-customer">
                    <img src="{{asset( 'storage/' . $model->avatar)}}" id="blah" alt="User profile picture">
                    <div class="foot-avatar" id="cc">
                        <label for="hidden-avatar">Đổi avatar</label>
                        <input hidden type="file" name="uploadfile" id="hidden-avatar">
                    </div>
                    @error('uploadfile')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="group">
                    <label for="">Họ tên <span class="text-red">*</span></label>
                    <input type="text" name="name" placeholder="Họ và tên" value="{{Auth::user()->name}}">
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="group">
                    <label for="">Email <span class="text-red">*</span></label>
                    <input type="text" name="email" placeholder="Emai" value="{{Auth::user()->email}}">
                    @error('password')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="group">
                    <label for="">Số điện thoại <span class="text-red">*</span></label>
                    <input type="text" name="phone" placeholder="Số điện thoại" value="{{Auth::user()->phone}}">
                </div>
                <div class="group">
                    <label for="city">Tỉnh/Thành phố</label>
                    <!--  -->
                    <select name="city" id="">
                            <option value="">Chọn thành phố</option>
                        @foreach($city as $city)
                            <option value="{{$city->id}}" >{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="group">
                    <label for="">Quận huyện</label>
                    <input type="text" name="district" placeholder="Quận huyện" value="{{$address}}">
                </div>
                <div class="group">
                    <label for="">Phường xã</label>
                    <input type="text" name="ward" placeholder="Phường xã" value="{{Auth::user()->address->address}}">
                </div>
                <div class="group">
                    <label for="">Địa chỉ <span class="text-red">*</span></label>
                    <textarea name="address" id="" cols="30" rows="10" placeholder="Địa chỉ, Phường xã, Quận huyện"></textarea>
                </div>
                @error('address')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="group-last">
                    <a href="{{route('client.customer.info')}}">Hủy bỏ</a>
                    <button type="submit">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</section>
	<!-- content -->
@endsection
@section('pagejs')
<script>
    var a = '';
        function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
					// $('#cc').append(`
					// 	<img class="add-product-preview-img" id="blah" src="#" alt="your image" />
					// `);
					document.getElementById("cc").style.display = 'block';
				reader.onload = function(e) {
					$('#blah').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
				}
			}
			$("#hidden-avatar").change(function() {
				readURL(this);
		});
</script>
@endsection