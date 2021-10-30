<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupons;
use App\Models\CouponType;
use App\Models\DiscountType;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index(Request $request){
        $pagesize = 7;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $coupon = Coupons::paginate($pagesize);
        }else{
            $couponQuery = Coupons::where('name', 'like', "%" .$request->keyword . "%");
            if($request->has('genre_type') && $request->genre_type != ""){
                $productQuery = $productQuery->where('genre_type', $request->genre_type);
            }
            $coupon = $couponQuery->paginate($pagesize)->appends($searchData);
        }
        
        $coupon->load('products', 'couponType', 'discountType');

        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        
        // trả về cho người dùng 1 giao diện + dữ liệu coupons vừa lấy đc 
        return view('admin.coupon.index', [
            'model' => $coupon,
            'couponType' => $couponType,
            'discountType' => $discountType,
            'searchData' => $searchData
        ]);
    }

    public function addForm(){
        $coupon = Coupons::all();
        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        $product = Product::all();
        return view('admin.coupon.add-form', compact('coupon', 'couponType', 'discountType', 'product'));
    }

    public function saveAdd(Request $request){
        $model = new Coupons(); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());

        // if ($request->has('forever')) {
        //     $model->start_date = 'jj';
        //     $model->end_date = 'jj';
        // }
        $model->user_id = Auth::user()->id;

        // $model->save();
        if($request->has('product_id')){
            foreach($request->product_id as $i => $item){
                $product = Product::find($id); 
                $product->discount = $request->discount;
                $product->discount_type = $request->discount_type;
                $product->discount_start_date = $request->start_date;
                $product->discount_end_date = $request->end_date;
                $product->save();
            }
        }
        dd($request->product_id);
    }
    public function editForm($id){
        $coupon = Coupons::find($id);
        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        $product = Product::all();
        if(!$coupon){
            return redirect()->back();
        }
        return view('admin.coupon.edit-form', compact('coupon', 'couponType', 'discountType', 'product'));
    }
    public function saveEdit(Request $request){}
    public function detail(Request $request){}
    public function remove(Request $request){}
}
