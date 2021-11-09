<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\AccessoryGallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccessoryController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 5;
        $searchData = $request->except('page');

        if (count($request->all()) == 0) {
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $accessories = Accessory::paginate($pagesize);
        } else {
            $accessoryQuery = Accessory::where('name', 'like', "%" . $request->keyword . "%");
            if ($request->has('category_id') && $request->category_id != "") {
                $accessoryQuery = $accessoryQuery->where('category_id', $request->category_id);
            }

            if ($request->has('order_by') && $request->order_by > 0) {
                if ($request->order_by == 1) {
                    $accessoryQuery = $accessoryQuery->orderBy('name');
                } else if ($request->order_by == 2) {
                    $accessoryQuery = $accessoryQuery->orderByDesc('name');
                } else if ($request->order_by == 3) {
                    $accessoryQuery = $accessoryQuery->orderBy('price');
                } else {
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

    public function addForm()
    {
        $category = Category::all();
        $discountType = DiscountType::all();
        return view('admin.accessory.add-form', compact('category', 'discountType'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $model = new Accessory();
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên phụ kiện đã tồn tại",
            'category_id.required' => "Hãy chọn danh mục",
            'price.required' => "Hãy nhập giá phụ kiện",
            'price.numeric' => "Giá phụ kiện phải là số",
            'status.required' => "Hãy chọn trạng thái phụ kiện",
            'quantity.required' => "Hãy nhập số lượng phụ kiện",
            'quantity.numeric' => "Số lượng phụ kiện phải là số",
            'galleries.required' => "Hãy chọn thư viện ảnh cho phụ kiện",
            'galleries.*.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'galleries.*.max' => 'File ảnh không được quá 2MB',
            'image.required' => 'Hãy chọn ảnh phụ kiện',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('accessories')->ignore($id)
                ],
                'category_id' => 'required',
                'price' => 'required|numeric',
                'status' => 'required',
                'quantity' => 'required|numeric',
                'galleries' => 'required',
                'galleries.*' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'image' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());

            if ($request->hasFile('image')) {
                $model->image = $request->file('image')->storeAs('uploads/accessories', uniqid() . '-' . $request->image->getClientOriginalName());
            }

            $model->user_id = Auth::id();
            $model->save();

            if ($request->has('galleries')) {
                foreach ($request->galleries as $i => $item) {
                    $galleryObj = new AccessoryGallery();
                    $galleryObj->accessory_id = $model->id;
                    $galleryObj->order_no = $i + 1;
                    $galleryObj->image_url = $item->storeAs(
                        'uploads/accessories/galleries/' . $model->id,
                        uniqid() . '-' . $item->getClientOriginalName()
                    );
                    $galleryObj->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/phu-kien')]);
    }

    public function editForm($id)
    {
        $model = Accessory::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $category = Category::all();
        $discountType = DiscountType::all();
        $model->load('galleries', 'category');
        return view('admin.accessory.edit-form', compact('model', 'category', 'discountType'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = Accessory::find($id);

        if (!$model) {
            return redirect()->back();
        }
        $message = [
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên phụ kiện đã tồn tại",
            'category_id.required' => "Hãy chọn danh mục",
            'price.required' => "Hãy nhập giá phụ kiện",
            'price.numeric' => "Giá phụ kiện phải là số",
            'status.required' => "Hãy chọn trạng thái phụ kiện",
            'quantity.required' => "Hãy nhập số lượng phụ kiện",
            'quantity.numeric' => "Số lượng phụ kiện phải là số",
            'galleries.*.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'galleries.*.max' => 'File ảnh không được quá 2MB',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('accessories')->ignore($id)
                ],
                'category_id' => 'required',
                'price' => 'required|numeric',
                'status' => 'required',
                'quantity' => 'required|numeric',
                'galleries.*' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());

            if ($request->hasFile('image')) {
                $model->image = $request->file('image')->storeAs('uploads/accessories', uniqid() . '-' . $request->image->getClientOriginalName());
            }

            $model->user_id = Auth::id();
            $model->save();
            /* gallery
         * xóa gallery đc mark là bị xóa đi
        */
            if ($request->has('removeGalleryIds')) {
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
            if ($request->has('galleries')) {
                foreach ($request->galleries as $i => $item) {
                    $galleryObj = new AccessoryGallery();
                    $galleryObj->accessory_id = $model->id;
                    $galleryObj->order_no = $i + 1;
                    $galleryObj->url = $item->storeAs(
                        'uploads/accessories/galleries/' . $model->id,
                        uniqid() . '-' . $item->getClientOriginalName()
                    );
                    $galleryObj->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/phu-kien')]);
    }

    public function detail($id)
    {
        $model = Accessory::find($id);
        $model->load('galleries', 'category');

        $category = Category::all();

        return view('admin.accessory.detail', compact('model', 'category'));
    }

    public function remove($id)
    {
        $accessory = Accessory::find($id);
        $accessory->galleries()->delete();
        $accessory->delete();
        return redirect()->back();
    }
}