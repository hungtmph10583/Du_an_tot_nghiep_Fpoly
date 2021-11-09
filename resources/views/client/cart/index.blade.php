@section('title', 'Sản phẩm')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/gio-hang.css')}}">
@endsection
	<!-- content -->
<div class="section-mt"></div>
<section class="search">
    <div class="container">
        <form action="" class="search-form">
            <div class="form-field">
                <input type="search" class="form-input" id="search-box" placeholder=" ">
                <label for="search" class="form-label"><i class="fas fa-search"></i> search here...</label>
            </div>
            <!-- <button for="search-box">
                <i class="fas fa-search"></i>
            </button> -->
        </form>
    </div>
</section>
<section class="cart-details">
    <div class="steps-to-take">
        <div class="step active" id="btn-cart">
            <i class="fas fa-shopping-cart"></i>
            <span>1. Giỏ hàng của tôi</span>
        </div>
        <div class="step" id="btn-address">
            <i class="fas fa-map-marked-alt"></i>
            <span>2. Địa chỉ nhận hàng</span>
        </div>
        <div class="step" id="btn-truck">
            <i class="fas fa-truck"></i>
            <span>3. Thông tin giao hàng</span>
        </div>
        <div class="step" id="btn-pay">
            <i class="fas fa-credit-card"></i>
            <span>4. Thanh toán</span>
        </div>
        <div class="step" id="btn-bill">
            <i class="far fa-check-circle"></i>
            <span>5. Xác nhận</span>
        </div>
    </div>
    <div class="cart-detail-container">
        <div class="carts active">
            <div class="carts-container">
                <div class="cart-item">
                    <div class="product-thumbnail">
                        <a href="#">
                            <img src="{{ asset('client-theme/images/cate-bird.jpg')}}" alt="">
                        </a>
                    </div>
                    <div class="product-info">
                        <h5 class="name">Vẹt bảy màu</h5>
                        <div class="category">
                            Danh mục: <span>Bird</span>
                        </div>
                        <div class="price">
                            Giá tiền: <span>12.300.000đ</span>
                        </div>
                        <div class="quantity">
                            Số lượng: <input type="number" value="1">
                        </div>
                        <div class="total">
                            Tổng: <span>12.300.000đ</span>
                        </div>
                    </div>
                    <div class="delete-product">
                        <button>
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="cart-item">
                    <div class="product-thumbnail">
                        <a href="#">
                            <img src="{{ asset('client-theme/images/cate-cat.jpg')}}" alt="">
                        </a>
                    </div>
                    <div class="product-info">
                        <h5 class="name">Mèo trắng mắt xanh</h5>
                        <div class="category">
                            Danh mục: <span>Cat</span>
                        </div>
                        <div class="price">
                            Giá tiền: <span>9.000.000đ</span>
                        </div>
                        <div class="quantity">
                            Số lượng: <input type="number" value="1">
                        </div>
                        <div class="total">
                            Tổng: <span>12.300.000đ</span>
                        </div>
                    </div>
                    <div class="delete-product">
                        <button>
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="item-last">
                    <div>
                        <a href="{{route('client.home')}}"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
                    </div>
                    <div>
                        <button class="btn-pay" id="cart-next"><span>Thanh toán</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="address">
            <div class="cart-detail-heading">
                <span>Thông tin liên lạc</span>
            </div>
            <form action="">
                <div class="form-group">
                    <input type="text" placeholder="Số điện thoại">
                </div>
                <div class="cart-detail-heading">
                    <span>Địa chỉ giao hàng</span>
                </div>
                <div class="form-group-double">
                    <input type="text" placeholder="Họ">
                    <input type="text" placeholder="Tên">
                </div>
                <div class="form-group">
                    <select name="" id="">
                        <option value="">Quốc gia</option>
                        <option value="">Việt Nam</option>
                        <option value="">Mỹ</option>
                        <option value="">Anh</option>
                        <option value="">Pháp</option>
                    </select>
                </div>
                <div class="form-group-double">
                    <select name="" id="">
                        <option value="">Thành phố</option>
                        <option value="">Hà Nội</option>
                        <option value="">Tp. Hồ Chí Minh</option>
                        <option value="">Hòa Bình</option>
                        <option value="">Lạng sơn</option>
                    </select>
                    <select name="" id="">
                        <option value="">Quận - Huyện</option>
                        <option value="">Nam từ liêm</option>
                        <option value="">Bắc từ liêm</option>
                        <option value="">Thanh xuân</option>
                        <option value="">Đống đa</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Địa chỉ nhà">
                </div>
                <div class="item-last">
                    <div>
                        <a href="#"><i class="fas fa-arrow-left"></i>Quay lại</a>
                    </div>
                    <div>
                        <button class="btn-pay" id="address-next"><span>Tiếp tục</span></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="truck">
            <div class="cart-detail-heading">
                <span>Thông tin nhận hàng</span>
            </div>
            <div class="truck-item-load">
                <label for="ghtn">Liên hệ</label>
                <span>+84 336 126 725</span>
                <a href="#">Thay đổi</a>
                <div class="clear-both"></div>
            </div>
            <div class="truck-item-load">
                <label for="ghst">Địa chỉ</label>
                <span>199 Hồ tùng mậu, Nam từ liêm, Hà Nội, Việt Nam</span>
                <a href="#">Thay đổi</a>
                <div class="clear-both"></div>
            </div>
            <div class="cart-detail-heading">
                <span>Phương pháp vận chuyển</span>
            </div>
            <div class="truck-item">
                <input type="radio" name="truck" id="ghtn" checked>
                <label for="ghtn">Giao hàng tận nhà</label>
                <span>15.000đ</span>
            </div>
            <div class="truck-item">
                <input type="radio" name="truck" id="ghst">
                <label for="ghst">Giao hàng siêu tốc</label>
                <span>35.000đ</span>
            </div>
            <div class="item-last">
                <div>
                    <a href="#"><i class="fas fa-arrow-left"></i> Quay lại</a>
                </div>
                <div>
                    <button class="btn-pay" id="truck-next"><span>Tiếp tục</span></button>
                </div>
            </div>
        </div>
        <div class="pay">
            <div class="pay-container">
                <div class="pay-first">
                    <div class="pay-first-top">
                        <div class="cart-detail-heading">
                            <span>Thanh toán</span>
                        </div>
                        <div class="pay-item down">
                            <input type="radio" id="ttck" name="pay">
                            <label for="ttck">Thanh toán qua ngân hàng</label>
                            <span>Bảo chì</span>
                        </div>
                        <div class="pay-item-sub" id="pay-item-sub">
                            <input type="text" placeholder="Card number">
                            <input type="text" placeholder="Name on card">
                            <div class="double">
                                <input type="text" placeholder="Expiration date (MM/YY)">
                                <input type="text" placeholder="Security code">
                            </div>
                        </div>
                        <div class="pay-item up">
                            <input type="radio" id="ttkgh" name="pay" checked>
                            <label for="ttkgh">Thanh toán khi nhận hàng</label>
                        </div>

                    </div>
                    <div class="pay-first-bottom">
                        <div class="note-heading">
                            <p>Thông tin chuyển khoản ngân hàng</p>
                            <span>(Nhân viên bán hàng sẽ liên hệ với quý khách)</span>
                        </div>
                        <div class="note-pay">
                            <p class="both">Quý khách có thể chuyển tiền thanh toán tới một trong các tài khoản sau</p>
                            <p>
                                Nội dung chuyển khoản:
                                <span class="both line-red">[Mã đơn hàng]</span> hoặc <span class="both line-red">[Số điện thoại của quý khách]</span>
                            </p>
                            <ul>
                                <li>
                                    <p>
                                        Chủ tài khoản:
                                        <span class="both">Trần Mạnh Hùng</span>
                                    </p>
                                    <p>
                                        Ngân hàng <span class="both">Agribank</span> - Chi nhánh Hòa Bình
                                    </p>
                                    <p>
                                        Số tài khoản: <span class="both line-red">3009205116961</span>
                                    </p>
                                </li><br>
                                <li>
                                    <p>
                                        Chủ tài khoản:
                                        <span class="both">Phan Quốc Huy</span>
                                    </p>
                                    <p>
                                        Ngân hàng <span class="both">Agribank</span> - Chi nhánh Nghệ An
                                    </p>
                                    <p>
                                        Số tài khoản: <span class="both line-red">3624205279069</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pay-second">
                    <div class="cart-detail-heading">
                        <span>Tóm tắt</span>
                    </div>
                    <div class="pay-second-container">
                        <div class="item">
                            <span class="both">Sản phẩm</span>
                            <span class="both">Tổng tiền</span>
                        </div>
                        <!-- (S) vòng lặp sp -->
                        <div class="item">
                            <span>Vẹt bảy màu</span>
                            <span>12.300.000đ</span>
                        </div>
                        <div class="item">
                            <span>Mèo trắng mắt xanh</span>
                            <span>9.000.000đ</span>
                        </div>
                        <!-- (E) vòng lặp sp -->
                        <div class="item">
                            <span class="both">Tổng thanh toán</span>
                            <span class="both">21.300.000đ</span>
                        </div>
                        <div class="item">
                            <span class="both">Thuế</span>
                            <span class="both">0.000đ</span>
                        </div>
                        <div class="item">
                            <span class="both">Chi phí vận chuyển</span>
                            <span class="both">15.000đ</span>
                        </div>
                        <div class="item">
                            <span class="both">Tổng tiền</span>
                            <span class="both total">21.315.000đ</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-last">
                <div>
                    <a href="#"><i class="fas fa-arrow-left"></i> Quay lại</a>
                </div>
                <div>
                    <button class="btn-pay" id="pay-next"><span>Tiếp tục</span></button>
                </div>
            </div>
        </div>
        <div class="bill">
            <div class="bill-container">
                <div class="bill-heading">
                    <div class="icon-comfirm">
                        <i class="far fa-check-circle"></i>
                    </div>
                    <div class="thanks">
                        <h3>Cảm ơn bạn đã đặt hàng!</h3>
                    </div>
                    <div class="bill-code">
                        <p>
                            Mã đặt hàng: <span class="both total">20215462-25423155</span>
                        </p>
                    </div>
                    <span class="note">Một bản sao tóm tắt đơn hàng của bạn đã được gửi đến hungtmph10583@gmail.com</span>
                </div>
                <div class="bill-content">
                    <div class="cart-detail-heading">
                        <span>Tóm tắt theo thứ tự</span>
                    </div>
                    <div class="bill-content-double">
                        <div class="group">
                            <div class="item">
                                <span class="both">Mã đặt hàng:</span>
                                <span>20215462-25423155</span>
                            </div>
                            <div class="item">
                                <span class="both">Tên khách hàng:</span>
                                <span>Hùng</span>
                            </div>
                            <div class="item">
                                <span class="both">Email:</span>
                                <span>hungtmph1058@gmail.com</span>
                            </div>
                            <div class="item">
                                <span class="both">Địa chỉ giao hàng</span>
                                <span>199 Hồ tùng mậu</span>
                            </div>
                        </div>
                        <div class="group">
                            <div class="item">
                                <span class="both">Ngày đặt hàng:</span>
                                <span>01-11-2021 13:53 PM</span>
                            </div>
                            <div class="item">
                                <span class="both">Trạng thái đơn hàng:</span>
                                <span>Đang chờ xử lý</span>
                            </div>
                            <div class="item">
                                <span class="both">Tổng số tiền đặt hàng:</span>
                                <span>21.300.000đ</span>
                            </div>
                            <div class="item">
                                <span class="both">Giao hàng: </span>
                                <span>Chuyển phát nhanh</span>
                            </div>
                            <div class="item">
                                <span class="both">Phương thức thanh toán: </span>
                                <span>Thanh toán khi giao hàng</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bill-content">
                    <div class="cart-detail-heading">
                        <span>Chi tiết đơn hàng</span>
                    </div>
                    <div class="bill-content-end">
                        <div class="group">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="both">#</th>
                                        <th class="both">Sản phẩm</th>
                                        <th class="both">Số lượng</th>
                                        <th class="both">Giá bán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Vẹt bảy màu</td>
                                        <td>1</td>
                                        <td>12.300.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Mèo trắng mắt xanh</td>
                                        <td>1</td>
                                        <td>9.000.000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="group"></div>
                    </div>
                    <div class="bill-content-end">
                        <div class="group"></div>
                        <div class="group">
                            <div class="item">
                                <span class="both">Tổng thanh toán</span>
                                <span class="both">21.300.000đ</span>
                            </div>
                            <div class="item">
                                <span class="both">Giao hàng</span>
                                <span>15.000đ</span>
                            </div>
                            <div class="item">
                                <span class="both">Thuế</span>
                                <span>0.000đ</span>
                            </div>
                            <div class="item">
                                <span class="both">Phiếu giảm giá</span>
                                <span>0.000đ</span>
                            </div>
                            <div class="item">
                                <span class="both">Tổng tiền</span>
                                <span class="both total">21.315.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-last">
                <div>
                    <!-- <a href="#"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a> -->
                </div>
                <div>
                    <button class="btn-pay"><a href="{{route('client.home')}}">Tiếp tục mua sắm</a></button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('pagejs')
<script src="{{ asset('client-theme/js/cart.js')}}"></script>
<script>
    var element = document.getElementById('pay-item-sub');
        document.getElementById('ttck').onclick = function(e) {
            if (this.checked) {
                element.classList.add("active");
            }
        };
        document.getElementById('ttkgh').onclick = function(e) {
            if (this.checked) {
                element.classList.remove("active");
            }
        };
</script>
@endsection