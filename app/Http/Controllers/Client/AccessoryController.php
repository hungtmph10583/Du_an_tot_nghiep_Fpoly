<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Age;
use App\Models\ProductGallery;
use App\Models\Review;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;

class AccessoryController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $searchData = $request->except('page');
        if(count($request->all()) == 0){
            //Lấy ra danh sách sản phẩm & phân trang cho nó
            $accessories = Accessory::paginate($pagesize);
        }else{
            $accessoryQuery = Accessory::where('name', 'like', "%" .$request->keyword . "%");
            $accessories = $accessoryQuery->paginate($pagesize)->appends($searchData);
        }
        $accessories->load('category');
        
        $categories = Category::all();
        $generalSetting = GeneralSetting::first();
        
        // trả về cho người dùng 1 giao diện + dữ liệu accessoríe vừa lấy đc 
        return view('client.accessory.index', [
            'accessory' => $accessories,
            'category' => $categories,
            'searchData' => $searchData,
            'generalSetting' => $generalSetting
        ]);
    }

    public function detail($id){
        $model = Accessory::where('slug', $id)->first();
        if (!$model) {
            return redirect()->back();
        }
        $pagesize = 5;
        $category = Category::all();
        $product_slide = Accessory::paginate(5);
        $generalSetting = GeneralSetting::first();

        $review = Review::where('accessory_id',$model->id)->paginate($pagesize);
        $countReview = Review::where('accessory_id',$model->id)->count();
        $rating = Review::where('accessory_id', $model->id)->avg('rating');
        $rating = (int)round($rating);
        return view('client.accessory.detail', compact('category', 'model', 'review', 'rating', 'countReview', 'generalSetting', 'product_slide'));
    }

    public function saveReview($id, Request $request){
        $model = new Review(); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->product_id = $id;
        $model->save();
        return redirect()->back();
    }
}
