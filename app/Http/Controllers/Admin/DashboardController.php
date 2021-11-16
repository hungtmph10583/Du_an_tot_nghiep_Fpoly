<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use Carbon;

class DashboardController extends Controller
{
    public function index(){
        $order = Order::all();
        $countDeliveryOrder1 = Order::where('delivery_status', 1)->count();
        $review = Review::all()->count();
        $orderDetail = OrderDetail::all();
        
        return view('admin.dashboard.index', compact('order', 'orderDetail', 'review'));
    }
}
