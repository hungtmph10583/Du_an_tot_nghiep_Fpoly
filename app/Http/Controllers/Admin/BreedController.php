<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BreedController extends Controller
{
    public function index(Request $request){
        $pagesize = 7;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $breed = Breed::paginate($pagesize);
        }else{
            $breedQuery = Breed::where('name', 'like', "%" .$request->keyword . "%");
            if($request->has('genre_type') && $request->genre_type != ""){
                $productQuery = $productQuery->where('genre_type', $request->genre_type);
            }
            $breed = $breedQuery->paginate($pagesize)->appends($searchData);
        }
        
        $breed->load('products', 'category');
        // trả về cho người dùng 1 giao diện + dữ liệu breed vừa lấy đc 
        return view('admin.breed.index', [
            'breed' => $breed,
            'searchData' => $searchData
        ]);
    }

    public function addForm(){
        $category = Category::all();
        return view('admin.breed.add-form', compact('category'));
    }
    
    public function saveAdd(Request $request){
        $model = new Breed();
        $model->fill($request->all());
        $name = $request->name;
        $slug = $request->name;
        /**
         * Chuyen doi ky tu chu thanh slug
         * @date: 28/09/21
         * hungtmph10583
         * Start
         */
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
        $model->name = ucwords($name);
        /**
         * End
         */
        if($request->has('uploadfile')){
            $model->image =$request->file('uploadfile')->storeAs('uploads/breeds/' . $model->id , 
                                    uniqid() . '-' . $request->uploadfile->getClientOriginalName());
            $model->save();
        }
        $model->user_id = Auth::user()->id;
        $model->save();
        return redirect(route('breed.index'));
    }

    public function editForm($id){
        $model = Breed::find($id);
        if(!$model){
            return redirect()->back();
        }
        $category = Category::all();
        return view('admin.breed.edit-form', compact('model', 'category'));
    }

    public function saveEdit($id, Request $request){
        $model = Breed::find($id); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());
        $name = $request->name;
        $slug = $request->name;
        /**
         * Chuyen doi ky tu chu thanh slug
         * @date: 28/09/21
         * hungtmph10583
         * Start
         */
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
        /**
         * End
         */
        
        $model->name = ucwords($name);
        if($request->has('uploadfile')){
            $model->image =$request->file('uploadfile')->storeAs('uploads/breeds/' . $model->id , 
                                    uniqid() . '-' . $request->uploadfile->getClientOriginalName());
            $model->save();
        }
        $model->user_id = Auth::user()->id;
        $model->save();
        return redirect(route('breed.index'));
    }

    public function detail($id){
        $model = breed::find($id);
        $model->load('products', 'category');

        $product = Product::all();
        $category = Category::all();

        return view('admin.breed.detail', compact('category', 'product', 'model'));
    }

    public function remove($id){
        $category = Category::find($id);
        $category->products()->delete();
        $category->delete();
        return redirect()->back();
    }
}
