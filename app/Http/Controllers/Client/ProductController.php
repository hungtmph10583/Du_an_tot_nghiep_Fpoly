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
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request){
        $pagesize = 10;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $products = Product::paginate($pagesize);
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

    public function detail($id)
    {
        $model = Product::find($id);
        $model->load('category', 'breed', 'gender');

        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();

        return view('client.product.detail', compact('category', 'model', 'breed', 'gender'));
    }
}
