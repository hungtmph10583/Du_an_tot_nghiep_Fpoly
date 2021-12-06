<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Mail;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.order.index');
    }

    public function getData(Request $request)
    {
        $order = Order::select('orders.*');
        return dataTables::of($order)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('order.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a  class="btn btn-success" href="' . route('order.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function editForm($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back();
        }
        $orderDetail = OrderDetail::where('order_id', $id)->get();
        return view('admin.order.edit-form', compact('order', 'orderDetail'));
    }

    public function saveEdit($id, Request $request)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back();
        }
        if ($order->delivery_status == 4) {
            return redirect(route('order.index'))->with('danger', "Khách đã hủy đơn hàng này. Cập nhật thất bại!");
        }
        $order->fill($request->all());
        $order->seller_id = Auth::user()->id;
        $order->save();

        $order_detail = OrderDetail::where('order_id', $id)->get();
        // dd($order_detail);

        foreach ($order_detail as $key => $value) {
            $orderDetail = OrderDetail::find($value->id);

            if ($order->payment_status == 1) {
                $orderDetail->payment_status = "Chưa thanh toán";
            } elseif ($order->payment_status == 2) {
                $orderDetail->payment_status = "Đã thanh toán";
            } else {
                $orderDetail->payment_status = "Lỗi code";
            }

            if ($order->delivery_status == 1) {
                $orderDetail->delivery_status = "Đang chờ xử lý";
            } elseif ($order->delivery_status == 2) {
                $orderDetail->delivery_status = "Đang giao hàng";
            } elseif ($order->delivery_status == 3) {
                $orderDetail->delivery_status = "Giao hàng thành công";
            } elseif ($order->delivery_status == 0) {
                $orderDetail->delivery_status = "Hủy đơn hàng";
            } else {
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
                "name" => "Website bán thú cưng LoliPetVN",
                "body" => $order->code,
                "name_client" => $order->name,
                "delivery_status" => $delivery_status,
                "order" => $order,
                "orderDetail" => $OutorderDetail
            ); // body of mail.blade.php
            Mail::send('mail.send-mail', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Cập nhật trạng thái đơn hàng'); //send this mail with subject
                $message->from($to_email, $to_name); // send from this mail
            });
        }
        return redirect(route('order.index'))->with('success', "Cập nhật thành công");
    }
}