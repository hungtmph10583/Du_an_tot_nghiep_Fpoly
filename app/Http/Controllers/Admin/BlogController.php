<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request){
        $pagesize = 7;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách tin tức & phân trang cho nó
            $blog = Blog::paginate($pagesize);
        }
        
        // trả về cho người dùng 1 giao diện + dữ liệu categories vừa lấy đc 
        return view('admin.blog.index', [
            'blog' => $blog,
            'searchData' => $searchData
        ]);
    }

    public function addForm(){
        return view('admin.blog.add-form');
    }

    public function saveAdd(Request $request){
        $model = new Blog();
        $model->fill($request->all());
        $title = $request->title;
        $slug = $request->tiele;
        
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
        $model->title = ucwords($title);
        /**
         * End
         */
        if($request->has('uploadfile')){
            $model->image =$request->file('uploadfile')->storeAs('uploads/blog/' . $model->id , 
                                    uniqid() . '-' . $request->uploadfile->getClientOriginalName());
            $model->save();
        }

        $model->creator = Auth::user()->id;
        $model->save();
        return redirect(route('blog.index'));
    }

    public function editForm($id){
        $model = Blog::find($id);
       
        if(!$model){
            return redirect()->back();
        }
        return view('admin.blog.edit-form', compact('model'));
    }

    public function saveEdit($id,Request $request){
        $model = Blog::find($id); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());
        $title = $request->title;
        $slug = $request->title;
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
        $model->title = ucwords($title);
        if($request->has('uploadfile')){
            $model->image =$request->file('uploadfile')->storeAs('uploads/blog/' . $model->id , 
                                    uniqid() . '-' . $request->uploadfile->getClientOriginalName());
            $model->save();
        }
        $model->save();
        return redirect(route('blog.index'));
    }

    public function detail($id)
    {
        $blog = Blog::find($id);

        return view('admin.blog.detail', compact('blog'));
    }

    public function remove($id){
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->back();
    }
}
