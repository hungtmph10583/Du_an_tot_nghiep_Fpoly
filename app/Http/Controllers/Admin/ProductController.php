<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\Storage;
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
        $pagesize = 5;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $products = Product::paginate($pagesize);
        }else{
            $productQuery = Product::where('name', 'like', "%" .$request->keyword . "%");
            if($request->has('category_id') && $request->category_id != ""){
                $productQuery = $productQuery->where('category_id', $request->category_id);
            }

            if($request->has('order_by') && $request->order_by > 0){
                if($request->order_by == 1){
                    $productQuery = $productQuery->orderBy('name');
                }else if($request->order_by == 2){
                    $productQuery = $productQuery->orderByDesc('name');
                }else if($request->order_by == 3){
                    $productQuery = $productQuery->orderBy('price');
                }else {
                    $productQuery = $productQuery->orderByDesc('price');
                }
            }
            $products = $productQuery->paginate($pagesize)->appends($searchData);
        }
        //$products->load('category', 'tags', 'company', 'galleries', 'product_tag');
        $products->load('category', 'breed', 'gender');
        
        $categories = Category::all();
        $gender = Gender::all();
        $breed = Breed::all();
        
        // trả về cho người dùng 1 giao diện + dữ liệu products vừa lấy đc 
        return view('admin.product.index', [
            'product' => $products,
            'category' => $categories,
            'gender' => $gender,
            'breed' => $breed,
            'searchData' => $searchData
        ]);
    }

    public function addForm(){
        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();
        $discountType = DiscountType::all();
        $age = Age::all();
        return view('admin.product.add-form', compact('category', 'breed', 'gender', 'age', 'discountType'));
    }

    public function saveAdd(Request $request){
        $model = new Product(); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());

        /**
         * @note: upload ảnh lên bảng phụ
         * @date: 03/10/21
         * @name: hungtm
         */

        /**
         * @note: huyen doi ky tu chu thanh slug
         * @date: 28/09/21
         * @name: hungtm
         */
        $slug = $request->name;
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($unicode as $key=>$value){
            $slug = preg_replace("/($value)/i", $key, $slug);
        }
        $slug = str_replace(' ','-',$slug);
        $model->slug = strtolower($slug);

        if($request->hasFile('uploadfile')){
            $model->image = $request->file('uploadfile')->storeAs('uploads/products', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }

        $model->user_id = Auth::user()->id;

        $model->save();

        if($request->has('galleries')){
            foreach($request->galleries as $i => $item){
                $galleryObj = new ProductGallery();
                $galleryObj->product_id = $model->id;
                $galleryObj->order_no = $i+1;
                $galleryObj->image_url = $item->storeAs('uploads/products/galleries/' . $model->id , 
                                        uniqid() . '-' . $request->uploadfile->getClientOriginalName());
                                        
                $galleryObj->save();
            }
        }
        
        //dd($request);
        // if ($request->has('ageInsert')) {
        //     $age = new Age();
        //     $age->age = $request->ageInsert;
        //     $age->save();
        //     $last = Age::all()->last();
        //     $request->age_id = $last->id;
        // }
        return redirect(route('product.index'));
    }

    public function editForm($id){
        $model = Product::find($id);
        if(!$model){
            return redirect()->back();
        }

        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();
        $age = Age::all();
        $discountType = DiscountType::all();

        $model->load('category', 'breed', 'gender', 'age');
        return view('admin.product.edit-form', compact('model', 'category', 'breed', 'gender', 'age', 'discountType'));
    }

    public function saveEdit($id, ProductFormRequest $request){
        $model = Product::find($id); 
        
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());
        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->image = $request->file('uploadfile')->storeAs('uploads/products', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }

        $model->creator = Auth::user()->id;
        $model->save();

        /* gallery
         * xóa gallery đc mark là bị xóa đi
        */
        if($request->has('removeGalleryIds')){
            $strIds = rtrim($request->removeGalleryIds, '|');
            $lstIds = explode('|', $strIds);
            // xóa các ảnh vật lý
            $removeList = ProductGallery::whereIn('id', $lstIds)->get();
            foreach ($removeList as $gl) {
                Storage::delete($gl->url);
            }
            ProductGallery::destroy($lstIds);
        }

        // lưu mới danh sách gallery
        if($request->has('galleries')){
            foreach($request->galleries as $i => $item){
                $galleryObj = new ProductGallery();
                $galleryObj->product_id = $model->id;
                $galleryObj->order_no = $i+1;
                $galleryObj->url = $item->storeAs('uploads/products/galleries/' . $model->id , 
                                        uniqid() . '-' . $item->getClientOriginalName());
                $galleryObj->save();
            }
        }

        return redirect(route('product.index'));
    }

    public function detail($id)
    {
        $model = Product::find($id);
        $model->load('category', 'breed', 'gender');

        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();

        return view('admin.product.detail', compact('category', 'model', 'breed', 'gender'));
    }

    public function remove($id){
        $product = Product::find($id);
        $product->product_tag()->delete();
        $product->delete();
        return redirect()->back();
    }
}