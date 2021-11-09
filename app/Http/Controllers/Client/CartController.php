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

class CartController extends Controller
{
    public function index(Request $request){
        $category = Category::all();
        $product = Product::all();
        $gender = Gender::all();
        $breed = Breed::all();
        
        return view('client.cart.index');
    }
}
