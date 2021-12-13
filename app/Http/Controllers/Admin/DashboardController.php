<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Review;
use App\Models\Statistical;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {


        $ss = Carbon::now()->daysInMonth;

        $order = Order::select(DB::raw('sum(grand_total) as sum'))
            ->where('payment_status', 2)
            ->where(function ($status) {
                $status->where('delivery_status', 2)
                    ->orWhere('delivery_status', 3);
            })
            ->where('updated_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('sum');

        $dataPet = [];
        $namePet = [];
        $userPet = [];

        $petPro = OrderDetail::join('products', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id', 'products.name as name', DB::raw('sum(order_details.quantity) as sum'), DB::raw('COUNT(order_id) as orderCount'))
            ->where('orders.payment_status', 2)
            ->where(function ($status) {
                $status->where('orders.delivery_status', 2)
                    ->orWhere('orders.delivery_status', 3);
            })
            ->where('order_details.product_type', 1)
            ->where('order_details.updated_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')
            ->groupBy('order_details.product_id')
            ->orderBy('sum', 'desc')
            ->get();

        foreach ($petPro as $sum) {
            if ($sum->sum > 0) {
                array_push($dataPet, $sum->sum);
                array_push($namePet, $sum->name);
                array_push($userPet, $sum->orderCount);
            }
        }
        $dataAcc = [];
        $nameAcc = [];
        $userAcc = [];

        $accPro = OrderDetail::join('accessories', 'accessories.id', '=', 'order_details.product_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id', 'accessories.name as name', DB::raw('sum(order_details.quantity) as sum'), DB::raw('COUNT(order_id) as orderCount'))
            ->where('orders.payment_status', 2)
            ->where(function ($status) {
                $status->where('orders.delivery_status', 2)
                    ->orWhere('orders.delivery_status', 3);
            })
            ->where('order_details.product_type', 2)
            ->where('order_details.updated_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')
            ->groupBy('order_details.product_id')
            ->orderBy('sum', 'desc')
            ->get();

        foreach ($accPro as $sum) {
            if ($sum->sum > 0) {
                array_push($dataAcc, $sum->sum);
                array_push($nameAcc, $sum->name);
                array_push($userAcc, $sum->orderCount);
            }
        }
        $countOrderDelivery = Order::where('delivery_status', 1)->count();
        if (request()->date_from && request()->date_to) {
            $countOrderDelivery = order::where('delivery_status', 1)->where('created_at', [request()->date_from, request()->date_to])->get();
        }

        $review = Review::where('status', 1)->count();
        $orderDetail = OrderDetail::all();

        return view('admin.dashboard.index', compact('order', 'orderDetail', 'review', 'countOrderDelivery', 'dataPet', 'namePet', 'userPet', 'dataAcc', 'nameAcc', 'userAcc'));
    }
}