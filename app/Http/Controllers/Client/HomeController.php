<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Slide;
use App\Models\Age;
use App\Models\ProductGallery;
use App\Models\Review;

class HomeController extends Controller
{
    public function home(Request $request){
        $category = Category::all();
        $product = Product::paginate(5);
        $gender = Gender::all();
        $breed = Breed::all();
        $slide = Slide::all();
        
        return view('client.home', [
            'category' => $category,
            'product' => $product,
            'gender' => $gender,
            'breed' => $breed,
            'slide' => $slide
        ]);
    }
}
