<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BreedController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 7;
        $searchData = $request->except('page');

        if (count($request->all()) == 0) {
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $breed = Breed::paginate($pagesize);
        } else {
            $breedQuery = Breed::where('name', 'like', "%" . $request->keyword . "%");
            if ($request->has('genre_type') && $request->genre_type != "") {
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

    public function addForm()
    {
        $category = Category::all();
        return view('admin.breed.add-form', compact('category'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'name.required' => "Hãy nhập vào tên sách",
            'name.unique' => "Tên thú cưng đã tồn tại",
            'category_id.required' => "Hãy chọn danh mục",
            'status.required' => "Hãy chọn trạng thái thú cưng",
            'uploadfile.required' => 'Hãy chọn ảnh thú cưng',
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('breeds')->ignore($id)
                ],
                'category_id' => 'required',
                'status' => 'required',
                'uploadfile' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model = new Breed();
            $auth = Auth::user();
            $model->fill($request->all());
            $model->user_id =  $auth->id;
            if ($request->has('uploadfile')) {
                $model->image = $request->file('uploadfile')->storeAs(
                    'uploads/breeds/' . $model->id,
                    uniqid() . '-' . $request->uploadfile->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/giong-loai')]);
    }

    public function editForm($id)
    {
        $model = Breed::find($id);
        if (!$model) {
            return redirect()->back();
        }
        $category = Category::all();
        return view('admin.breed.edit-form', compact('model', 'category'));
    }

    public function saveEdit($id, Request $request)
    {
        $message = [
            'name.required' => "Hãy nhập vào tên sách",
            'name.unique' => "Tên thú cưng đã tồn tại",
            'category_id.required' => "Hãy chọn danh mục",
            'status.required' => "Hãy chọn trạng thái thú cưng",
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('breeds')->ignore($id)
                ],
                'category_id' => 'required',
                'status' => 'required',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model = Breed::find($id);
            $auth = Auth::user();
            $model->fill($request->all());
            $model->user_id =  $auth->id;
            if ($request->has('uploadfile')) {
                $model->image = $request->file('uploadfile')->storeAs(
                    'uploads/breeds/' . $model->id,
                    uniqid() . '-' . $request->uploadfile->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/giong-loai')]);
    }

    public function detail($id)
    {
        $model = breed::find($id);
        $model->load('products', 'category');

        $product = Product::all();
        $category = Category::all();

        return view('admin.breed.detail', compact('category', 'product', 'model'));
    }

    public function remove($id)
    {
        $category = Category::find($id);
        $category->products()->delete();
        $category->delete();
        return redirect()->back();
    }
}