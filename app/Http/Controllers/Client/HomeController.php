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
use App\Models\Order;

class HomeController extends Controller
{
    public function home(Request $request)
    {


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
            'generalSetting' => $generalSetting
        ]);
    }

    public function search(Request $request)
    {
        $slide = Slide::all();
        $generalSetting = GeneralSetting::first();
        $category = Category::all();
        $searchData = $request->except('page');
        switch ($request->search_type) {
            case '1':
                if ($request->search) {
                    $order = Order::where('code', 'like', '%' . $request->search . '%')->paginate(5)->appends($searchData);
                }

                return view('client.search.search', [
                    'order' => $order,
                    'slide' => $slide,
                    'generalSetting' => $generalSetting,
                    'category' => $category,
                    'searchData' => $searchData
                ]);
                break;
            case '2':
                if ($request->search) {
                    $product = Product::where('name', 'like', '%' . $request->search . '%')->paginate(5)->appends($searchData);
                }

                return view('client.search.search', [
                    'product' => $product,
                    'slide' => $slide,
                    'generalSetting' => $generalSetting,
                    'category' => $category,
                    'searchData' => $searchData
                ]);
                break;
            case '3':
                if ($request->search) {
                    $accessory = Accessory::where('name', 'like', '%' . $request->search . '%')->paginate(5)->appends($searchData);
                }
                return view('client.search.search', [
                    'accessory' => $accessory,
                    'slide' => $slide,
                    'generalSetting' => $generalSetting,
                    'category' => $category,
                    'searchData' => $searchData
                ]);
                break;
            case '4':
                if ($request->search) {
                    $blog = Blog::where('title', 'like', '%' . $request->search . '%')->paginate(5)->appends($searchData);
                }
                return view('client.search.search', [
                    'blog' => $blog,
                    'slide' => $slide,
                    'generalSetting' => $generalSetting,
                    'category' => $category,
                    'searchData' => $searchData
                ]);
                break;
        }
    }
}