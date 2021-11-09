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
                </div>
                <div class="group">
                    <label for="">Họ tên <span class="text-red">*</span></label>
                    <input type="text" name="name" placeholder="Họ và tên" value="{{Auth::user()->name}}">
                </div>
                <div class="group">
                    <label for="">Email <span class="text-red">*</span></label>
                    <input type="text" name="email" placeholder="Emai" value="{{Auth::user()->email}}" disabled>
                </div>
                <div class="group">
                    <label for="">Số điện thoại <span class="text-red">*</span></label>
                    <input type="text" name="phone" placeholder="Số điện thoại" value="{{Auth::user()->phone}}">
                </div>
                <div class="group">
                    <label for="">Quốc gia</label>
                    <select name="country" id="">
                        <option value="">Việt Nam</option>
                    </select>
                </div>
                <div class="group">
                    <label for="city">Tỉnh/Thành phố</label>
                    <select name="" id="">
                        <option value="">Hà Nội</option>
                    </select>
                </div>
                <div class="group">
                    <label for="">Quận huyện</label>
                    <select name="" id="">
                        <option value="">Quận Nam Từ Liêm</option>
                    </select>
                </div>
                <div class="group">
                    <label for="">Phường xã</label>
                    <select name="" id="">
                        <option value="">Phường cầu diễn</option>
                    </select>
                </div>
                <div class="group">
                    <label for="">Địa chỉ <span class="text-red">*</span></label>
                    <textarea name="" id="" cols="30" rows="10" value="{{Auth::user()->address}}"></textarea>
                </div>
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