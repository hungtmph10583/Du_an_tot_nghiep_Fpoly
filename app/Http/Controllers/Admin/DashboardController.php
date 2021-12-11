<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role: Manage');
    // }

    public function index(Request $request){

        $list_order_month = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())
                        ->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())
                        ->where('delivery_status', 3)->where('payment_status', 2)->get();

        $doanh_thu = 0;
        foreach ($list_order_month as $key => $value) {
            $totail = 0;
            $money = OrderDetail::where('order_id', $value->id)->first();
            $totail = $money->price - $money->tax;
            $doanh_thu += $totail;
        }

        $don_hang_dang_trong_thang = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())
                                            ->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->get();

        $don_hang_dang_bi_huy = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())
                                        ->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())
                                        ->where('delivery_status', 4)->get();

        $countOrderDelivery = Order::where('delivery_status', 1)->count();
        if (request()->date_from && request()->date_to) {
            $countOrderDelivery = order::where('delivery_status', 1)->where('created_at', [request()->date_from, request()->date_to])->get();
            dd('check');
        }

        // dd($countOrderDelivery);
        // $review = Review::all()->count(); // Đếm số lượng review
        $orderDetail = OrderDetail::all();


        
        return view('admin.dashboard.index', compact(
            // 'orderDetail', 
            // 'review', 
            'countOrderDelivery', 
            'doanh_thu', 'don_hang_dang_trong_thang', 'don_hang_dang_bi_huy',
            'list_order_month',
            'orderDetail'
        ));
    }

    
}
