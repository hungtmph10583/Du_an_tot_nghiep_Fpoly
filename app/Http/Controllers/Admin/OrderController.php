<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Mail;

class OrderController extends Controller
{
    public function index(Request $request){
        $pagesize = 7;
        $searchData = $request->except('page');
        $dateOrder = Order::orderBy('created_at', 'DESC');
        if(count($request->all()) == 0){
            $order = $dateOrder->paginate($pagesize);
        }else{
            $orderQuery = Order::where('phone', 'like', "%" . $request->keyword . "%")->orderBy('created_at', 'DESC');
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
        return view('admin.order.edit-form', compact('order', 'orderDetail'));
    }

    public function saveEdit($id, Request $request){
        $order = Order::find($id);
        if(!$order){
            return redirect()->back();
        }
        if($order->delivery_status == 4){
            return redirect(route('order.index'))->with('danger', "Khách đã hủy đơn hàng này. Cập nhật thất bại!");
        }
        $order->fill($request->all());
        $order->seller_id = Auth::user()->id;
        $order->save();

        $order_detail = OrderDetail::where('order_id', $id)->get();
        // dd($order_detail);

        foreach ($order_detail as $key => $value) {
            $orderDetail = OrderDetail::find($value->id);

            if($order->payment_status == 1){
                $orderDetail->payment_status = "Chưa thanh toán";
            }elseif($order->payment_status == 2){
                $orderDetail->payment_status = "Đã thanh toán";
            }else{
                $orderDetail->payment_status = "Lỗi code";
            }

            if($order->delivery_status == 1){
                $orderDetail->delivery_status = "Đang chờ xử lý";
            }elseif($order->delivery_status == 2){
                $orderDetail->delivery_status = "Đang giao hàng";
            }elseif($order->delivery_status == 3){
                $orderDetail->delivery_status = "Giao hàng thành công";
            }elseif($order->delivery_status == 0){
                $orderDetail->delivery_status = "Hủy đơn hàng";
            }else{
                $orderDetail->delivery_status = "Lỗi code";
            }

            $orderDetail->save();
        }

        // return redirect(route('order.index'));

        // Gửi mail cập nhật trạng thái đơn hàng
        if ($request->has('send_mail')) {
            $orderDetail = OrderDetail::where('order_id', $id)->first();
            $OutorderDetail = OrderDetail::where('order_id', $id)->get();
            $productName = Product::where('id', $orderDetail->product_id)->first();
    
            $to_name = "LoliPetVN";
            $to_email = $order->email;
            $code_order = $order->code;
    
            if ($order->delivery_status == 1) {
                $delivery_status = 'Đã tiếp nhận đơn hàng. Đang chờ xử lý!';
            } elseif ($order->delivery_status == 2) {
                $delivery_status = 'Đơn hàng của bạn đã được gửi';
            } elseif ($order->delivery_status == 3) {
                $delivery_status = 'Hoàn thành đơn hàng!';
            } else {
                $delivery_status = 'Đơn hàng của bạn đã bị hủy!';
            }
    
            $data = array(
                "name"=>"Website bán thú cưng LoliPetVN",
                "body"=> $order->code,
                "name_client" => $order->name,
                "delivery_status" => $delivery_status,
                "order" => $order,
                "orderDetail" => $OutorderDetail
            ); // body of mail.blade.php
            Mail::send('mail.send-mail',$data,function($message) use ($to_name,$to_email){
                $message->to($to_email)->subject('Cập nhật trạng thái đơn hàng'); //send this mail with subject
                $message->from($to_email,$to_name);// send from this mail
            });
        }
        return redirect(route('order.index'))->with('success', "Cập nhật thành công");
    }
}
