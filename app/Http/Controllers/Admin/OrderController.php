<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function index(Request $request){
        $pagesize = 7;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách tin tức & phân trang cho nó
            $order = Order::paginate($pagesize);
        }else{
            $orderQuery = Order::where('name', 'like', "%" . $request->keyword . "%");
            $order = $orderQuery->paginate($pagesize)->appends($searchData);
        }
        $order->load('orderDetails');

        $orderDetail = OrderDetail::all();
        // trả về cho người dùng 1 giao diện + dữ liệu categories vừa lấy đc 
        return view('admin.order.index', [
            'order' => $order,
            'orderDetail' => $orderDetail,
        ]);
    }

    public function editForm($id){
        $order = Order::find($id);
        if(!$order){
            return redirect()->back();
        }
        $orderDetail = OrderDetail::where('order_id', $id)->get();

        // dd($orderDetail);
        return view('admin.order.edit-form', compact('order', 'orderDetail'));
    }

    public function saveEdit($id, Request $request){
        // dd($request);
        $order = Order::find($id);
        if(!$order){
            return redirect()->back();
        }
        $order->fill($request->all());
        $order->save();
        return redirect(route('order.index'));
    }
}
