@section('title', 'Liên hệ')
@extends('layouts.client.main')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/contact.css')}}">
@endsection
@section('content')
    <section class="contact">
        <div class="bread-crumb">
            <a href="{{route('client.home')}}">Trang chủ</a>
            <span>Liên hệ</span>
        </div>
        <h1 id="heading">Liên hệ</h1>
        <div class="link_map_address">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8638558814587!2d105.74459841533215!3d21.038132792833153!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b991d80fd5%3A0x53cefc99d6b0bf6f!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1638181372341!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="information">
            <div class="box-info">
                <div class="contact-box">
                    <span>
                        <i class="fas fa-home"></i>
                    </span>
                    <p>
                        <label for="">Địa chỉ:</label> Số 168 Thượng Đình – Thanh Xuân – Hà Nội
                    </p>
                </div>
                <div class="contact-box">
                    <span>
                        <i class="fas fa-phone-alt"></i>
                    </span>
                    <p>
                        <label for="">Điện thoại:</label> 033 6126 724
                    </p>
                </div>
                <div class="contact-box">
                    <span>
                        <i class="fas fa-at"></i>
                    </span>
                    <p>
                        <label for="">Email:</label> <a href="#">lolipetvn@gmail.com</a>
                    </p>
                </div>
                <div class="contact-box">
                    <span>
                        <i class="fab fa-facebook-f"></i>
                    </span>
                    <p>
                        <label for="">Facebook:</label> lolipetvn
                    </p>
                </div>
            </div>
        </div>
        <div class="post_contact">
            <h2 class="title">Gửi góp ý cho chúng tôi.</h2>
            <form action="">
                <div class="contact_box">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Name*" name="name">
                </div>
                <div class="contact_box">
                    <i class="fas fa-envelope"></i>
                    <input type="text" placeholder="Email*" name="email">
                </div>
                <div class="contact_box">
                    <i class="far fa-edit"></i>
                    <textarea name="message" placeholder="Nội dung*" id="" cols="30" rows="10"></textarea>
                </div>
                <button>Send Mail</button>
            </form>
        </div>
    </section>
@endsection