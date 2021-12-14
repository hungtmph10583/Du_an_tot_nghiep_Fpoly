<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Slide;
use App\Models\Age;
use App\Models\ProductGallery;
use App\Models\Review;
use App\Models\Blog;
use App\Models\GeneralSetting;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home(Request $request){
        $carbon_now = Carbon::now();
        $category = Category::all();
        $product = Product::paginate(5);
        $accessory = Accessory::paginate(5);
        $gender = Gender::all();
        $breed = Breed::all();
        $slide = Slide::all();
        $blog = Blog::orderBy('created_at', 'DESC')->paginate(2);
        $generalSetting = GeneralSetting::first();
        
        return view('client.home', [
            'category' => $category,
            'product' => $product,
            'accessory' => $accessory,
            'gender' => $gender,
            'breed' => $breed,
            'slide' => $slide,
            'blog' => $blog,
            'carbon_now' => $carbon_now,
            'generalSetting' => $generalSetting
        ]);
    }
}
