<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Age;
use App\Models\ProductGallery;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\GeneralSetting;
use App\Models\Statistical;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use SweetAlert;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->back()->with('success', "Đã thêm sản phẩm vào giỏ hàng (gio hang rong)");
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
                        return redirect()->back()->with('danger', "Bạn không thể thêm số lượng đó vào trong giỏ hàng vì chúng tôi chỉ còn " . $product_info->quantity . " sản phẩm trong kho và giỏ hàng của bạn đang có " . $_qty . " sản phẩm này (alert danger one).");
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
                    return redirect()->back()->with('danger', "Bạn không thể thêm số lượng đó vào trong giỏ hàng vì chúng tôi chỉ còn " . $product_info->quantity . " sản phẩm trong kho và bạn đang có " . $_qty . " sản phẩm này trong giỏ hàng (alert danger two).");
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
                return redirect()->back()->with('success', "Đã thêm sản phẩm vào giỏ hàng 3");
            }
        }
    }

    public function buyNow(Request $request)
    { //Giỏ hàng
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
        } else {
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
        $model->shipping_address = $request->address . ", " . $request->ward . ", " . $request->district . ", " . $request->city;
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

            $models = Statistical::where('product_id', $value->id)
                ->where('product_type', $value->weight)
                ->where('updated_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')->first();
            if ($value->weight == 1) {
                $product = Product::find($value->id);
            } else {
                $product = Accessory::find($value->id);
            }

            if ($models) {
                if ($product->quantity >= $models->quantity) {
                    $sum = $models->quantity + $value->qty;
                    if ($sum <= $models->quantityMonth) {
                        $models->quantity += $value->qty;
                        $models->save();
                    }
                }
            } else {
                $model = new Statistical();
                $model->order_id = 0;
                $model->product_id = $value->id;
                $model->product_type = $value->weight;
                $model->quantity = $value->qty;
                $model->quantityMonth = $product->quantity;
                $model->save();
            }
        }

        $content = Cart::content();
        foreach ($content as $key => $value) {
            $rowId = $value->rowId;
            Cart::update($rowId, 0);
        }
        // return view('client.cart.index');
        return Redirect::to("gio-hang/");
    }
}