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
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $carbon_now = Carbon::now();
        $pagesize = 5;
        $searchData = $request->except('page');
        if (count($request->all()) == 0) {
            //Lấy ra danh sách sản phẩm & phân trang cho nó
            $products = Product::paginate($pagesize);
        } else {
            $productQuery = Product::where('name', 'like', "%" . $request->keyword . "%");
            $products = $productQuery->paginate($pagesize)->appends($searchData);

            if ($request->has('cate_id') && $request->cate_id != "") {
                $productQuery = $productQuery->where('category_id', $request->cate_id);
            }

            if ($request->has('order_by') && $request->order_by > 0) {
                if ($request->order_by == 1) {
                    $productQuery = $productQuery->orderBy('price');
                } else if ($request->order_by == 2) {
                    $productQuery = $productQuery->orderByDesc('price');
                } else {
                    $productQuery = $productQuery->orderBy('created_at', 'DESC');
                }
            }
            $products = $productQuery->paginate($pagesize)->appends($searchData);

            if ($request->has('cate_id') && $request->cate_id != "") {
                $productQuery = $productQuery->where('category_id', $request->cate_id);
            }

            if($request->has('order_by') && $request->order_by > 0){
                if($request->order_by == 1){
                    $productQuery = $productQuery->orderBy('price');
                }else if($request->order_by == 2){
                    $productQuery = $productQuery->orderByDesc('price');
                }else{
                    $productQuery = $productQuery->orderBy('created_at', 'DESC');
                }
            }
            $products = $productQuery->paginate($pagesize)->appends($searchData);
        }
        $products->load('category', 'breed', 'gender');

        $categories = Category::all();
        $gender = Gender::all();
        $breed = Breed::all();
        $generalSetting = GeneralSetting::first();

        // trả về cho người dùng 1 giao diện + dữ liệu products vừa lấy đc 
        return view('client.product.index', [
            'product' => $products,
            'category' => $categories,
            'gender' => $gender,
            'breed' => $breed,
            'searchData' => $searchData,
            'carbon_now' => $carbon_now,
            'generalSetting' => $generalSetting
        ]);
    }

    public function detail($id)
    {
        $model = Product::where('slug', $id)->first();
        $carbon_now = Carbon::now();
        if (!$model) {
            return redirect()->back();
        }
        //$model->load('category', 'breed', 'gender');
        $pagesize = 5;
        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();
        $product_slide = Product::paginate(5);
        $generalSetting = GeneralSetting::first();

        $review = Review::where('product_id', $model->id)->where('product_type', '1')->paginate($pagesize);
        $countReview = Review::where('product_id', $model->id)->where('product_type', '1')->count();
        $rating = Review::where('product_id', $model->id)->where('product_type', '1')->avg('rating');
        $rating = (int)round($rating);

        if (Auth::check()) {
            $check_rv = Review::where('product_id', $model->id)->where('product_type', '1')->where('user_id', Auth::user()->id)->first();
            return view('client.product.detail', compact('category', 'model', 'breed', 'gender', 'review', 'rating', 'countReview', 'generalSetting', 'product_slide', 'check_rv', 'carbon_now'));
        } else {
            return view('client.product.detail', compact('category', 'model', 'breed', 'gender', 'review', 'rating', 'countReview', 'generalSetting', 'product_slide', 'carbon_now'));
        }
    }

    public function saveReview(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'rating' => 'required',
                'comment' => 'required'
            ],
            [
                'name.required' => "Hãy nhập vào tên của bạn!",
                'email.required' => "Hãy nhập vào email!",
                'rating.required' => "Hãy chọn đánh giá sao!",
                'comment.required' => "Hãy Nhập vào nội dung!"
            ]
        );

        $check_review = Review::where('email', $request->email)->where('product_id', $request->product_id)->where('product_type', $request->product_type)->first();
        $check_order = Order::where('email', $request->email)->where('delivery_status', '3')->get();
        if (!empty(count($check_order))) {
            foreach ($check_order as $key => $value) {
                $check_order_detail = OrderDetail::where('order_id', $value->id)->where('product_id', $request->product_id)->where('product_type', $request->product_type)->get();
            }
            if (!empty(count($check_order_detail))) {
                if (!empty($check_review)) {
                    $find_review = Review::find($check_review->id);
                    $find_review->fill($request->all());
                    $find_review->product_id = $request->product_id;
                    $find_review->product_type = $request->product_type;
                    if (Auth::check()) {
                        $find_review->user_id = Auth::user()->id;
                    }
                    $find_review->name = $request->name;
                    $find_review->email = $request->email;
                    $find_review->rating = $request->rating;
                    $find_review->comment = $request->comment;
                    $find_review->status = true;
                    $find_review->save();
                    return redirect()->back()->with('success', 'Cập nhật nhận xét thành công')->withInput();
                } else {
                    $review = new Review;
                    $review->fill($request->all());
                    $review->product_id = $request->product_id;
                    $review->product_type = $request->product_type;
                    if (Auth::check()) {
                        $review->user_id = Auth::user()->id;
                    }
                    $review->name = $request->name;
                    $review->email = $request->email;
                    $review->rating = $request->rating;
                    $review->comment = $request->comment;
                    $review->status = true;
                    $review->save();
                    return redirect()->back()->with('success', 'Nhận xét thành công')->withInput();
                }
            } else {
                return redirect()->back()->with('danger', 'Đơn hàng của bạn đang được xử lí. Quay lại bình luận khi bạn đã nhận được sản phẩm này!')->withInput();
            }
        } else {
            return redirect()->back()->with('danger', 'Vui lòng sử dụng Email đã mua sản phẩm này để bình luận.')->withInput();
        }
    }
}