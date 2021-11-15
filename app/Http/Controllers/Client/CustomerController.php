<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Address;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\ModelHasRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function accountInfo (){
        $model = User::find(Auth::user()->id);
        $model->load('address');
        return view('client.customer.account-info', compact('model'));
    }

    public function updateinfo(){
        $model = User::find(Auth::user()->id);

        $address = Address::all();
        // dd($address);
        $city = City::all();
        return view('client.customer.updateinfo', [
            'model' => $model,
            'address' => $address,
            'city' => $city
        ]);
    }

    public function saveUpdateinfo(Request $request){
        $user = Auth::user()->id;
        $model = User::find($user);
        if(!$model){
            return redirect()->back();
        }
        $request->validate(
            [
                'name' => 'required|min:3|max:32',
                'email' => 'required|email',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg',
            ],
            [
                'name.required' => "Hãy nhập vào tên",
                'email.required' => "Hãy nhập email",
                'email.email' => "Không đúng định dạng email",
                'uploadfile.mimes' => 'File ảnh đại diện không đúng định dạng (jpg, bmp, png, jpeg)',
            ]
        );

        $model->fill($request->all());
        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->avatar = $request->file('uploadfile')->storeAs('uploads/users', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();

        if($request->has('address')){
            $check = Address::where('user_id', $user)->get();
            if (!Address::where('user_id', $user)) {
                $city = City::find($request->city);
                $newaddress = new Address();
                $newaddress->user_id = $user;
                $newaddress->address = $request->address.", ".$request->ward.", ".$request->district.", ".$city->name;
                $newaddress->city_id = $request->city;
                $newaddress->save();
            }else{
                $city = City::find($request->city);
                $newaddress = Address::fint(Auth::user()->address->id);
                $newaddress->user_id = $user;
                $newaddress->address = $request->address.", ".$request->ward.", ".$request->district.", ".$city->name;
                $newaddress->city_id = $request->city;
                $newaddress->save();
            }
            // $city = City::find($request->city);
            // $newaddress = new Address();
            // $newaddress->user_id = $user;
            // $newaddress->address = $request->address.", ".$request->ward.", ".$request->district.", ".$city->name;
            // $newaddress->city_id = $request->city;
            // $newaddress->save();
        }
        return redirect(route('client.customer.info'));
    }

    public function orderHistory(){
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)->get();
        // $product = Product::where('product', $user_id)->firstOrFail();
        $order->load('orderDetails');

        $orderDetail = OrderDetail::all();

        // dd($order);

        return view('client.customer.order-history', compact(
            'order',
            'orderDetail'
        ));
    }

    public function review(){
        $user_id = Auth::user()->id;
        $review = Review::where('user_id', $user_id)->get();
        $review->load('product');

        // dd($review);

        $product = Product::all();

        // $rating = Review::where('product_id', $id)->avg('rating');
        // $rating = (int)round($rating);
        return view('client.customer.review', compact(
            'review',
            'product'
        ));
    }

    public function deleteReview($id){
        $review = Review::find($id);
        $review->delete();
        return redirect()->back();
    }

    public function favoriteProduct(){
        return view('client.customer.favorite-product');
    }
}
