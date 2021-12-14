<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\SendMailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\DiscountType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\GeneralSetting;
use App\Models\Statistical;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use SweetAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::all();
        $product = Product::all();
        $accessory = Accessory::all();
        $generalSetting = GeneralSetting::first();

        return view('client.cart.index', compact('category', 'accessory', 'product', 'generalSetting'));
    }

    public function saveCart(Request $request)
    { //Giỏ hàng
        // dd($request);
        if ($request->quantity <= 0) {
            return redirect()->back();
        }

        $product_id = $request->product_id_hidden;
        $quantity = $request->quantity;

        $category = Category::where('id', $request->category_id)->first();
        $category_type_id = $category->category_type_id;

        if ($request->product_type == 1) {
            $product_info = Product::where('id', $product_id)->first();
            $id__po = $product_info->id;
        } elseif ($request->product_type == 2) {
            $product_info = Accessory::where('id', $product_id)->first();
            $id__po = $product_info->id;
        } else {
            return redirect()->back()->with('danger', "Error!");
        }
        $content = Cart::content();
        $count = Cart::content()->count();

        if (empty($count)) {
            $data['id'] = $product_id;
            $data['qty'] = $quantity;
            $data['name'] = $product_info->name;
            if ($request->discount_price > 0) {
                $data['price'] = $product_info->price - $request->discount_price;
            } else {
                $data['price'] = $product_info->price;
            }
            $data['weight'] = $request->product_type;
            $data['options']['image'] = $product_info->image;
            Cart::add($data);
            Cart::setGlobalTax(10);
            return redirect()->back()->with('success', "Đã thêm sản phẩm vào giỏ hàng.");
        } else {
            foreach (Cart::content() as $row) {
                if ($row->id == $id__po && $row->weight == $category_type_id) {
                    $_id = $row->id;
                    $_qty = $row->qty;
                    break;
                } elseif ($row->id == $id__po && $row->weight == $category_type_id) {
                    $_id = $row->id;
                    $_qty = $row->qty;
                    break;
                }
            }
            if (!empty($_id)) {
                if ($_qty < $product_info->quantity) { // Số lượng sp từ giở hàng < Số lượng từ DB
                    $tinh = $quantity + $_qty;
                    if ($tinh > $product_info->quantity) {
                        return redirect()->back()->with('danger', "Bạn không thể thêm số lượng đó vào trong giỏ hàng vì chúng tôi chỉ còn " . $product_info->quantity . " sản phẩm trong kho và giỏ hàng của bạn đang có " . $_qty . " sản phẩm này!");
                    } else {
                        $data['id'] = $product_id;
                        $data['qty'] = $quantity;
                        $data['name'] = $product_info->name;
                        if ($request->discount_price > 0) {
                            $data['price'] = $product_info->price - $request->discount_price;
                        } else {
                            $data['price'] = $product_info->price;
                        }
                        $data['weight'] = $request->product_type;
                        $data['options']['image'] = $product_info->image;
                        Cart::add($data);
                        Cart::setGlobalTax(10);
                        return redirect()->back()->with('success', "Đã thêm sản phẩm vào giỏ hàng 2");
                    }
                } else {
                    return redirect()->back()->with('danger', "Bạn không thể thêm số lượng đó vào trong giỏ hàng vì chúng tôi chỉ còn " . $product_info->quantity . " sản phẩm trong kho và bạn đang có " . $_qty . " sản phẩm này trong giỏ hàng!");
                }
            } else {
                $data['id'] = $product_id;
                $data['qty'] = $quantity;
                $data['name'] = $product_info->name;
                if ($request->discount_price > 0) {
                    $data['price'] = $product_info->price - $request->discount_price;
                } else {
                    $data['price'] = $product_info->price;
                }
                $data['weight'] = $request->product_type;
                $data['options']['image'] = $product_info->image;
                Cart::add($data);
                Cart::setGlobalTax(10);
                return redirect()->back()->with('success', "Đã thêm sản phẩm vào giỏ hàng.");
            }
        }
    }

    public function deleteToCart($rowId)
    {
        Cart::update($rowId, 0);
        return redirect(route('client.cart.index'))->with('success', "Đã xóa sản phẩm khỏi giỏ hàng!");
    }

    public function updateCartQty(Request $request)
    {
        if ($request->quantity_cart <= 0) {
            return redirect()->back()->with('danger', "Error!");
        }
        $rowId = $request->rowId_cart;
        $quantity = $request->quantity_cart;
        Cart::update($rowId, $quantity);
        return redirect(route('client.cart.index'))->with('success', "Cập nhật số lượng sản phẩm thành công!");
    }

    public function checkout(Request $request)
    {
        $category = Category::all();
        $generalSetting = GeneralSetting::first();

        $content = Cart::content()->count();
        //dd($content);
        if ($content > 0) {
            return view('client.checkout.payment', compact('category', 'generalSetting'));
        } else {
            return redirect()->back();
        }
    }
    public function saveCheckout(Request $request)
    {
        $model = new Order();
        $request->validate(
            [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'city' => 'required',
                'district' => 'required',
                'ward' => 'required',
                'address' => 'required',
            ],
            [
                'name.required' => "Hãy nhập vào tên",
                'phone.required' => "Hãy nhập số điện thoại",
                'email.required' => "Nhập vào email để theo dõi đơn hàng của bạn",
                'city.required' => "Nhập vào thông tin Thành Phố",
                'district.required' => "Nhập vào thông tin Quận \ Huyện",
                'ward.required' => "Nhập vào thông tin Xã \ Phường",
                'address.required' => "Nhập vào thông tin Địa chỉ",
            ]
        );

        $model->fill($request->all());
        if (Auth::check()) {
            $model->user_id = Auth::user()->id;
        }
        $model->shipping_address = $request->address . ", " . $request->ward . ", " . $request->district . ", " . $request->city;
        $model->payment_type = "Trả tiền khi nhận hàng";
        $model->payment_status = 1;
        $model->delivery_status = 1;
        $model->grand_total = $request->grand_total;
        $model->code = date('dmY-His');
        $model->save();

        $id_order = $model->id;
        $content = Cart::content();
        // dd($content, $request);

        foreach ($content as $key => $value) {
            $orderDetail = new OrderDetail();

            $orderDetail->order_id = $id_order;
            $orderDetail->product_id = $value->id;
            $orderDetail->product_type = $value->weight;
            $orderDetail->price = $value->priceTotal;
            $orderDetail->tax = $request->tax;

            $orderDetail->shipping_cost = 0;
            $orderDetail->shipping_type = "Giao hàng tận nhà";

            $orderDetail->payment_status = "Chưa thanh toán";
            $orderDetail->delivery_status = "Đang chờ xử lý";

            $orderDetail->quantity = $value->qty;
            $orderDetail->save();

            if ($value->weight == 1) {
                $update_product = Product::find($value->id);
                $tru = $update_product->quantity - $value->qty;
                $update_product->quantity = $tru;
                $update_product->save();
            } else {
                $update_product = Accessory::find($value->id);
                $tru = $update_product->quantity - $value->qty;
                $update_product->quantity = $tru;
                $update_product->save();
            }
        }

        // ---------------------------------------------------------
        $id_first = Order::where('phone', $request->phone)->orderBy('created_at', 'DESC')->first();
        $order_Detail = OrderDetail::where('order_id', $id_first->id)->get();
        $product = Product::all();
        $generalSetting = GeneralSetting::first('logo');
        $accessory = Accessory::all();
        // dd($generalSetting);
        $total = 0;
        foreach ($order_Detail as $key => $value) {
            $total += $value->price;
        }
        $name_client = $request->name;
        $number_phone = $request->phone;
        $to_email = $request->email;
        $order_code = $id_first->code;
        $date_time_order = $id_first->created_at->format('d/m/Y');
        $shipping_address = $request->address . ", " . $request->ward . ", " . $request->district . ", " . $request->city;
        $total = number_format($total, 0, ',', '.');
        $tax = number_format($request->tax, 0, ',', '.');
        $grand_total = number_format($request->grand_total, 0, ',', '.');

        $mailData = [
            'name_client' => $name_client,
            'number_phone' => $number_phone,
            'to_email' => $to_email,
            'order_code' => $order_code,
            'date_time_order' => $date_time_order,
            'shipping_address' => $shipping_address,
            'grand_total' => $grand_total,
            'orderDetail' => $order_Detail,
            'product' => $product,
            'accessory' => $accessory,
            'tax' => $tax,
            'total' => $total,
            'generalSetting' => $generalSetting
        ];
        $toMail = $to_email;
        Mail::to($toMail)->send(new SendMailOrder($mailData));
        // Send-mail-order E)
        foreach ($content as $key => $value) { // Xóa sản phẩm trong giỏ hàng sau khi lưu dữ liệu và gửi mail
            $rowId = $value->rowId;
            Cart::update($rowId, 0);
        } // Xóa sản phẩm trong giỏ hàng sau khi lưu dữ liệu và gửi mail
        return Redirect::to("gio-hang/")->with('success', "Đặt hàng thành công!");
    }
}