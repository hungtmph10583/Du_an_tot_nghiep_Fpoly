<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\AccessoryGallery;

class AccessoryController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $accessories = Accessory::paginate($pagesize);
        }else{
            $accessoryQuery = Accessory::where('name', 'like', "%" .$request->keyword . "%");
            if($request->has('category_id') && $request->category_id != ""){
                $accessoryQuery = $accessoryQuery->where('category_id', $request->category_id);
            }

            if($request->has('order_by') && $request->order_by > 0){
                if($request->order_by == 1){
                    $accessoryQuery = $accessoryQuery->orderBy('name');
                }else if($request->order_by == 2){
                    $accessoryQuery = $accessoryQuery->orderByDesc('name');
                }else if($request->order_by == 3){
                    $accessoryQuery = $accessoryQuery->orderBy('price');
                }else {
                    $accessoryQuery = $accessoryQuery->orderByDesc('price');
                }
            }
            $accessories = $accessoryQuery->paginate($pagesize)->appends($searchData);
        }
        $accessories->load('category');
        
        $categories = Category::all();
        
        // trả về cho người dùng 1 giao diện + dữ liệu accessorys vừa lấy đc 
        return view('admin.accessory.index', [
            'accessory' => $accessories,
            'category' => $categories,
            
            'searchData' => $searchData
        ]);
    }

    public function addForm(){
        $category = Category::all();
        $discountType = DiscountType::all();
        return view('admin.accessory.add-form', compact('category', 'discountType'));
    }

    public function saveAdd(Request $request){
        $model = new Accessory(); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());

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
            $model->image = $request->file('uploadfile')->storeAs('uploads/accessories', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }

        
        //dd($request->id);
        $model->save();

        if($request->has('galleries')){
            foreach($request->galleries as $i => $item){
                $galleryObj = new AccessoryGallery();
                $galleryObj->accessory_id = $model->id;
                $galleryObj->order_no = $i+1;
                $galleryObj->image_url = $item->storeAs('uploads/accessories/galleries/' . $model->id , 
                                        uniqid() . '-' . $request->uploadfile->getClientOriginalName());
                $galleryObj->save();
            }
        }
        return redirect(route('accessory.index'));
    }

    public function editForm($id){
        $model = Accessory::find($id);
        if(!$model){
            return redirect()->back();
        }

        $category = Category::all();
        $discountType = DiscountType::all();
        $model->load('galleries', 'category');
        return view('admin.accessory.edit-form', compact('model', 'category', 'discountType'));
    }

    public function saveEdit($id, Request $request){
        $model = Accessory::find($id); 
        
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());
        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->image = $request->file('uploadfile')->storeAs('uploads/accessories', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();

        /* gallery
         * xóa gallery đc mark là bị xóa đi
        */
        if($request->has('removeGalleryIds')){
            $strIds = rtrim($request->removeGalleryIds, '|');
            $lstIds = explode('|', $strIds);
            // xóa các ảnh vật lý
            $removeList = AccessoryGallery::whereIn('id', $lstIds)->get();
            foreach ($removeList as $gl) {
                Storage::delete($gl->url);
            }
            AccessoryGallery::destroy($lstIds);
        }

        // lưu mới danh sách gallery
        if($request->has('galleries')){
            foreach($request->galleries as $i => $item){
                $galleryObj = new AccessoryGallery();
                $galleryObj->accessory_id = $model->id;
                $galleryObj->order_no = $i+1;
                $galleryObj->url = $item->storeAs('uploads/accessories/galleries/' . $model->id , 
                                        uniqid() . '-' . $item->getClientOriginalName());
                $galleryObj->save();
            }
        }

        return redirect(route('accessory.index'));
    }

    public function detail($id)
    {
        $model = Accessory::find($id);
        $model->load('galleries', 'category');

        $category = Category::all();

        return view('admin.accessory.detail', compact('model', 'category'));
    }

    public function remove($id){
        $accessory = Accessory::find($id);
        $accessory->galleries()->delete();
        $accessory->delete();
        return redirect()->back();
    }
}
