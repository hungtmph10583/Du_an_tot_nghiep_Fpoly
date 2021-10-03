<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index(Request $request){
        $pagesize = 7;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $categories = Category::paginate($pagesize);
        }else{
            $categoryQuery = Category::where('name', 'like', "%" .$request->keyword . "%");
            if($request->has('genre_type') && $request->genre_type != ""){
                $productQuery = $productQuery->where('genre_type', $request->genre_type);
            }
            $categories = $categoryQuery->paginate($pagesize)->appends($searchData);
        }
        
        $categories->load('products');
        // trả về cho người dùng 1 giao diện + dữ liệu categories vừa lấy đc 
        return view('admin.category.index', [
            'cates' => $categories,
            'searchData' => $searchData
        ]);
    }

    public function addForm(){
        return view('admin.category.add-form');
    }
    
    public function saveAdd(CategoryFormRequest $request){
        $model = new Category();
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
        $model->save();
        return redirect(route('category.index'));
    }

    public function editForm($id){
        $model = Category::find($id);
        if(!$model){
            return redirect()->back();
        }
        return view('admin.category.edit-form', compact('model'));
    }

    public function saveEdit($id, CategoryFormRequest $request){
        $model = Category::find($id); 
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
        $model->save();
        return redirect(route('category.index'));
    }

    public function detail($id)
    {
        $cate = Category::find($id);
        $cate->load('products');
        return view('admin.category.detail', ['cate' => $cate]);
    }

    public function remove($id){
        $category = Category::find($id);
        $category->products()->delete();
        $category->delete();
        return redirect()->back();
    }
}
