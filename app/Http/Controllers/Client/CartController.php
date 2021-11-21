<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Age;
use App\Models\ProductGallery;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderDetail;
use Cart;
use SweetAlert;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request){
        $category = Category::all();
        $product = Product::all();
        $gender = Gender::all();
        $breed = Breed::all();
        
        return view('client.cart.index');
    }

    public function saveCart(Request $request){//Giỏ hàng
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
        $data['weight'] = $product_info->price;
        $data['options']['image'] = $product_info->image;
        Cart::add($data);
        Cart::setGlobalTax(10);
        return redirect()->back()->with('msg', "Đã thêm sản phẩm vào giỏ hàng");
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
        $data['weight'] = $product_info->price;
        $data['options']['image'] = $product_info->image;
        Cart::add($data);
        Cart::setGlobalTax(10);
        return redirect('gio-hang/checkout');
    }

    // public function muaHang(Request $request){
    //     $product_id = $request->product_id_hidden;
    //     $quantity = $request->quantity;
    //     $product_info = Product::where('id', $product_id)->first();

    //     $data['id'] = $product_id;
    //     $data['qty'] = $quantity;
    //     $data['name'] = $product_info->name;
    //     $data['price'] = $product_info->price;
    //     $data['weight'] = $product_info->price;
    //     $data['options']['image'] = $product_info->image;
    //     Cart::add($data);
    //     Cart::setGlobalTax(10);
    //     return redirect(route('showCart'));
    // }


    public function showCart(Request $request){
        $category = Category::all();
        $gender = Gender::all();
        $breed = Breed::all();

        return view('client.cart.index', compact('category','gender','breed'));
    }

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
        $gender = Gender::all();
        $breed = Breed::all();

        $content = Cart::content()->count();
        //dd($content);
        if ($content > 0) {
            return view('client.checkout.payment', compact('category','gender','breed'));
        }else{
            return redirect()->back();
        }
    }

    public function saveCheckout(Request $request){
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
            $orderDetail->price = $value->priceTotal;
            $orderDetail->tax = $request->tax;

            $orderDetail->shipping_cost = 0;
            $orderDetail->shipping_type = "Giao hàng tận nhà";

            $orderDetail->payment_status = 1;
            $orderDetail->delivery_status = 1;

            $orderDetail->quantity = $value->qty;
            $orderDetail->save();
        }
        
        $content = Cart::content();
        foreach ($content as $key => $value) {
            $rowId = $value->rowId;
            Cart::update($rowId,0);
        }
        return view('client.cart.index');
    }
}
