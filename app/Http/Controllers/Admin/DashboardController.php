<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $ss = Carbon::now()->daysInMonth;
        // dd($ss);

        $order = Order::all();
        $countOrderDelivery = Order::where('delivery_status', 1)->count();
        if (request()->date_from && request()->date_to) {
            $countOrderDelivery = order::where('delivery_status', 1)->where('created_at', [request()->date_from, request()->date_to])->get();
        }
        $countDeliveryOrder1 = Order::where('delivery_status', 1)->count(); // Đếm số lượng đơn hàng chưa xử lý
        $review = Review::all()->count(); // Đếm số lượng review
        $orderDetail = OrderDetail::all();

        return view('admin.dashboard.index', compact('order', 'orderDetail', 'review', 'countOrderDelivery'));
    }
}