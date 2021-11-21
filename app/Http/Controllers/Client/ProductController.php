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
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $searchData = $request->except('page');
        if(count($request->all()) == 0){
            //Lấy ra danh sách sản phẩm & phân trang cho nó
            $products = Product::paginate($pagesize);
        }else{
            $productQuery = Product::where('name', 'like', "%" .$request->keyword . "%");
            $products = $productQuery->paginate($pagesize)->appends($searchData);
        }
        $products->load('category', 'breed', 'gender');
        
        $categories = Category::all();
        $gender = Gender::all();
        $breed = Breed::all();
        
        // trả về cho người dùng 1 giao diện + dữ liệu products vừa lấy đc 
        return view('client.product.index', [
            'product' => $products,
            'category' => $categories,
            'gender' => $gender,
            'breed' => $breed,
            'searchData' => $searchData
        ]);
    }

    public function detail($id){
        $model = Product::where('slug', $id)->first();
        if (!$model) {
            return redirect()->back();
        }
        //$model->load('category', 'breed', 'gender');
        $pagesize = 5;
        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();


        $review = Review::where('product_id',$model->id)->paginate($pagesize);
        $countReview = Review::where('product_id',$model->id)->count();
        $rating = Review::where('product_id', $model->id)->avg('rating');
        $rating = (int)round($rating);
        return view('client.product.detail', compact('category', 'model', 'breed', 'gender', 'review', 'rating', 'countReview'));
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
