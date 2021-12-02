<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Age;
use App\Models\ProductGallery;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\GeneralSetting;
use Cart;
use SweetAlert;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request){
        $category = Category::all();
        $product = Product::all();
        $accessory = Accessory::all();
        $generalSetting = GeneralSetting::first();
        
        return view('client.cart.index', compact('category','accessory','product','generalSetting'));
    }

    public function saveCart(Request $request){//Giỏ hàng
        // dd($request);
        if ($request->quantity <= 0) {
            return redirect()->back();
        }

        $product_id = $request->product_id_hidden;
        $quantity = $request->quantity;
        

        if ($request->product_type == 1) {
            $product_info = Product::where('id', $product_id)->first();
        } elseif($request->product_type == 2){
            $product_info = Accessory::where('id', $product_id)->first();
        }

        // Check quantity (S)
        $content = Cart::content();
        if (!empty($content)) {
            $data['id'] = $product_id;
            $data['qty'] = $quantity;
            $data['name'] = $product_info->name;
            if ($request->discount_price > 0) {
                $data['price'] = $product_info->price - $request->discount_price;
            }else{
                $data['price'] = $product_info->price;
            }
            $data['weight'] = $request->product_type;
            $data['options']['image'] = $product_info->image;
            Cart::add($data);
            Cart::setGlobalTax(10);
            return redirect()->back()->with('message', "Đã thêm sản phẩm vào giỏ hàng");
        }else{
            foreach (Cart::content() as $value) {
                if ($value->id == $product_info->id) {
                    if ($value->qty < $product_info->quantity) {
                        $tinh = $quantity + $value->qty;
                        if ($tinh > $product_info->quantity) {
                            return redirect()->back()->with('message', "Bạn không thể thêm số lượng đó vào trong giỏ hàng vì chúng tôi chỉ còn " . $product_info->quantity ." sản phẩm trong kho và giỏ hàng của bạn đang có " . $value->qty . " sản phẩm này.");
                        }else{
                            $data['id'] = $product_id;
                            $data['qty'] = $quantity;
                            $data['name'] = $product_info->name;
                            if ($request->discount_price > 0) {
                                $data['price'] = $product_info->price - $request->discount_price;
                            }else{
                                $data['price'] = $product_info->price;
                            }
                            $data['weight'] = $product_info->price;
                            $data['options']['image'] = $product_info->image;
                            Cart::add($data);
                            Cart::setGlobalTax(10);
                            return redirect()->back()->with('message', "Đã thêm sản phẩm vào giỏ hàng");
                        }
                    }else{
                        return redirect()->back()->with('message', "Bạn không thể thêm số lượng đó vào trong giỏ hàng vì chúng tôi chỉ còn " . $product_info->quantity ." sản phẩm trong kho và bạn đang thêm " . $quantity . " vào giỏ hàng.");
                    }
                }
            }
        }
        // Check quantity (E)

        // $data['id'] = $product_id;
        // $data['qty'] = $quantity;
        // $data['name'] = $product_info->name;
        // if ($request->discount_price > 0) {
        //     $data['price'] = $product_info->price - $request->discount_price;
        // }else{
        //     $data['price'] = $product_info->price;
        // }
        // $data['weight'] = $product_info->price;
        // $data['options']['image'] = $product_info->image;
        // Cart::add($data);
        // Cart::setGlobalTax(10);
        // return redirect()->back()->with('message', "Đã thêm sản phẩm vào giỏ hàng");
    }

    public function buyNow(Request $request){//Giỏ hàng
        if ($request->quantity <= 0) {
            return redirect()->back();
        }

        $product_id = $request->product_id_hidden;
        $quantity = $request->quantity;
        $product_info = Product::where('id', $product_id)->first();

        $data['id'] = $product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->name;
        if ($request->discount_price > 0) {
            $data['price'] = $product_info->price - $request->discount_price;
        }else{
            $data['price'] = $product_info->price;
        }
        $data['weight'] = $request->product_type;
        $data['options']['image'] = $product_info->image;
        Cart::add($data);
        Cart::setGlobalTax(10);
        return redirect('gio-hang/checkout');
    }

    // public function showCart(Request $request){
    //     $category = Category::all();
    //     $product = Product::all();
    //     $accessory = Accessory::all();
    //     dd($accessory);
    //     $generalSetting = GeneralSetting::first();

    //     return view('client.cart.index', compact('category','product','accessory','generalSetting'));
    // }

    public function deleteToCart($rowId){
        Cart::update($rowId,0);
        return redirect(route('client.cart.index'))->with('message', "Đã xóa sản phẩm!");
    }

    public function updateCartQty(Request $request){
        if ($request->quantity_cart <= 0) {
            return redirect()->back();
        }
        $rowId = $request->rowId_cart;
        $quantity = $request->quantity_cart;
        Cart::update($rowId,$quantity);
        return redirect(route('client.cart.index'));
    }

    public function checkout(Request $request){
        $category = Category::all();
        $generalSetting = GeneralSetting::first();

        $content = Cart::content()->count();
        //dd($content);
        if ($content > 0) {
            return view('client.checkout.payment', compact('category','generalSetting'));
        }else{
            return redirect()->back();
        }
    }

    public function saveCheckout(Request $request){
        // dd($request);
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
        $model->shipping_address = $request->address.", ".$request->ward.", ".$request->district.", ".$request->city;
        $model->payment_type = "Trả tiền khi nhận hàng";
        $model->payment_status = 1;
        $model->delivery_status = 1;
        $model->grand_total = $request->grand_total;
        $model->code = date('dmY-His');

        $model->save();

        $id_order = $model->id;
        $content = Cart::content();

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
        }
        
        $content = Cart::content();
        foreach ($content as $key => $value) {
            $rowId = $value->rowId;
            Cart::update($rowId,0);
        }
        // return view('client.cart.index');
        return Redirect::to("gio-hang/");
    }
}
