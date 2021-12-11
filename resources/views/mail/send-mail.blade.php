<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send mail</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }
        .container{
            max-width: 40rem;
            padding: 1rem;
            border: 0.1rem solid #f5f6f8;
            border-radius: 0.5rem;
            box-shadow: 1px 1px 1px #868080;
            background-color: #fff;
            margin: 1rem auto;
        }
        .container .logo{
            text-align: center;
        }
        .container .logo img{
            height: 5rem;
        }
        .container .thanks{
            font-size: 1rem;
            text-align: center;
            color: #6bb64a;
            margin: 1rem 0;
        }
        .container h2{
            line-height: 2;
        }

        .container .title{
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .container .button{
            text-align: center;
        }
        .container .button a{
            position: relative;
            display: inline-block;
            padding: 1rem 2rem;
            font-size: 1rem;
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
            border-radius: 0.5rem;
            letter-spacing: 2px;
            overflow: hidden;
            background: linear-gradient(90deg,#6bb64a,#ccff33);
        }
        .bold{
            font-weight: bold;
        }
        .text-red{
            color: #F62217;
        }

        .container .note{
            padding: 1rem 0;
            line-height: 1.5;
        }
        .container table tbody tr td{
            line-height: 2;
            color: #868080;
        }
        .container table tbody tr td a{
            color: #1155cc;
        }
        .detail{
            padding-top: 1rem;
        }
        .detail p{
            line-height: 1.5;
        }
        .detail .space-between{
            padding-top: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container .product{
            padding: 1rem 0;
        }
        .container .totail table{
            border-bottom:1px solid #d8d8d8;
        }
        .container .delivery_status{
            padding-top: 1rem;
        }
        .container .footer{
            text-align: center;
            padding-top: 1rem;
        }
        .container .footer a{
            position: relative;
            display: block;
            padding: 1rem 2rem;
            font-size: 1rem;
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
            border-radius: 0.5rem;
            letter-spacing: 2px;
            overflow: hidden;
            background: linear-gradient(90deg,#6bb64a,#ccff33);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <a href="#">
                <img src="./public/images/logo_full.png" alt="">
            </a>
        </div>
        <p class="thanks">Cám ơn bạn đã đặt hàng tại LoliPetVN!</p>
        <h2>Xin chào Khánh Ngọc,</h2>
        <p class="title">
            Chúng tôi đã nhận được yêu cầu đặt hàng của bạn và đang xử lý. Bạn sẽ nhận được thông báo tiếp theo khi đơn hàng đã sẵn sàng được giao.
        </p>
        <div class="button">
            <a href="#" class="bold" id="link">TÌNH TRẠNG ĐƠN HÀNG</a>
        </div>
        <p class="note">
            <span class="bold">*Lưu ý: </span>
            Bạn chỉ nên nhận hàng khi trạng thái đơn hàng là <span class="bold">Đang giao hàng </span> và nhớ kiểm tra <span class="bold">Mã đơn hàng</span>. Thông tin người gửi để nhận đúng kiện hàng nhé.
        </p>
        <div class="content">
            <p>Đơn hàng được giao đến:</p>
            <table cellpadding="2" cellspacing="0" width="100%">
                <tbody>
                   <tr>
                        <td width="25%" valign="top" class="bold">Tên:</td>
                   </tr>
                    <tr>
                        <td valign="top" class="bold">Địa chỉ nhà:</td>
                        <td valign="top">Huyện Yên Thuỷ, Hòa Bình, Thị trấn Hàng Trạm, khu 6 thị trấn hàng trạm, yên thủy, hòa bình  - </td>
                    </tr>
                    <tr>
                        <td valign="top" class="bold">Điện thoại:</td>
                        <td valign="top">0961316491</td>
                    </tr>
                    <tr>
                        <td valign="top" class="bold">Email:</td>
                        <td valign="top"><a href="mailto:khanhngoc2791@gmail.com" target="_blank">khanhngoc2791@gmail.com</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="detail">
            <p>Kiện hàng #2</p>
            <div class="space-between">
                <span>Đặt vào: 21/11/2021></span>
                <span>Giao vào: 23/11 - 26/11/2021</span>
            </div>
            <div class="product">
                <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tbody>
                        <tr>
                            <td style="width:40%">
                                <div style="padding-right:10px">
                                    <a href="#" >
                                        <img src="{{ asset('client-theme/images/logo.png')}}" alt="" style="width:100%;max-width:160px">
                                    </a>
                                </div>
                            </td>
                            <td style="width:60%">
                                <div>
                                    <a href="#">
                                        <span>Hello kidty</span>
                                    </a>
                                </div>
                                <div><span>VND 254.000</span></div>
                                <div><span>Số lượng: 1</span></div>
                              </td>
                        </tr>
                        <tr>
                            <td style="width:40%">
                                <div style="padding-right:10px">
                                        <a href="#" >
                                            <img src="{{ asset('client-theme/images/logo.png')}}" alt="" style="width:100%;max-width:160px">
                                        </a>
                                </div>
                            </td>
                            <td style="width:60%">
                                <div>
                                    <a href="#">
                                        <span>Hello kidty</span>
                                    </a>
                                </div>
                                <div><span>VND 254.000</span></div>
                                <div><span>Số lượng: 1</span></div>
                              </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="totail">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td valign="top" style="width:49%">Thành tiền:</td>
                            <td align="right" valign="top">254.000 VND</td>
                        </tr>
                        <tr>
                            <td valign="top">Phí vận chuyển:</td>
                            <td align="right" valign="top">44.000 VND</td>
                        </tr>
                        <tr>
                            <td valign="top">Giảm giá:</td>
                            <td align="right" valign="top">(20.000) VND</td>
                        </tr>
                        <tr>
                            <td valign="top" class="bold">Tổng cộng:</td>
                            <td align="right" valign="top" class="bold text-red">
                                278.000 VND
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="delivery_status">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td valign="top" style="width:49%">Hình thức vận chuyển:</td>
                            <td align="right" valign="top">Giao hàng nhanh</td>
                        </tr>
                        <tr>
                            <td valign="top">Hình thức thanh toán:</td>
                            <td align="right" valign="top">Thanh toán khi nhận hàng</td>
                        </tr>                                    
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer">
            <a href="mailto:lolipetvn@gmail.com" target="_blank">lolipetvn@gmail.com</a>
        </div>
    </div>
</body>

</html>