<div class="info_customer">
    <div class="avatar">
        <img src="{{asset( 'storage/' . Auth::user()->avatar)}}" id="blah" alt="User profile picture">
    </div>
    <div class="info">
        <h5>{{Auth::user()->name}}</h5>
        <p>Trưởng Nhóm</p>
    </div>
    <div class="nav_bar">
        <ul>
            <li>
                <a href="{{route('client.customer.info')}}" id="link_info">
                    <i class="fas fa-user"></i>
                    Thông tin tài khoản
                </a>
            </li>
            <li>
                <a href="{{route('client.customer.orderHistory')}}" id="link_order">
                    <i class="fas fa-swatchbook"></i>
                    Quản lý đơn hàng
                </a>
            </li>
            <li>
                <a href="{{route('client.customer.review')}}" id="link_review">
                    <i class="fas fa-star-half-alt"></i>
                    Nhận xét của tôi
                </a>
            </li>
        </ul>
    </div>
</div>