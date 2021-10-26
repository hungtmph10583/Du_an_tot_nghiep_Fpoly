<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Product;
use App\Models\Breed;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 7;
        $searchData = $request->except('page');

        if (count($request->all()) == 0) {
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $categories = Category::paginate($pagesize);
        } else {
            $categoryQuery = Category::where('name', 'like', "%" . $request->keyword . "%");
            if ($request->has('genre_type') && $request->genre_type != "") {
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

    public function addForm()
    {
        $categoryType = CategoryType::all();
        return view('admin.category.add-form', compact('categoryType'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'name.required' => "Hãy nhập vào tên sách",
            'name.unique' => "Tên thú cưng đã tồn tại",
            'category_type_id.required' => "Hãy chọn danh mục",
            'show_slide.required' => "Hãy chọn trạng thái thú cưng",
            'uploadfile.required' => 'Hãy chọn ảnh thú cưng',
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('categories')->ignore($id)
                ],
                'category_type_id' => 'required',
                'show_slide' => 'required',
                'uploadfile' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model = new Category();
            $model->fill($request->all());
            if ($request->has('uploadfile')) {
                $model->image = $request->file('uploadfile')->storeAs(
                    'uploads/categories/' . $model->id,
                    uniqid() . '-' . $request->uploadfile->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/danh-muc')]);
    }

    public function editForm($id)
    {
        $model = Category::find($id);
        $categoryType = CategoryType::all();
        if (!$model) {
            return redirect()->back();
        }
        return view('admin.category.edit-form', compact('model', 'categoryType'));
    }

    public function saveEdit($id, CategoryFormRequest $request)
    {
        $model = Category::find($id);
        if (!$model) {
            return redirect()->back();
        }
        $message = [
            'name.required' => "Hãy nhập vào tên sách",
            'name.unique' => "Tên thú cưng đã tồn tại",
            'category_type_id.required' => "Hãy chọn danh mục",
            'show_slide.required' => "Hãy chọn trạng thái thú cưng",
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('categories')->ignore($id)
                ],
                'category_type_id' => 'required',
                'show_slide' => 'required',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());
            if ($request->has('uploadfile')) {
                $model->image = $request->file('uploadfile')->storeAs(
                    'uploads/categories/' . $model->id,
                    uniqid() . '-' . $request->uploadfile->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/danh-muc')]);
    }

    public function detail($id)
    {
        $category = Category::find($id);
        $category->load('products', 'breeds');

        $product = Product::all();
        $breed = Breed::all();

        return view('admin.category.detail', compact('category', 'product', 'breed'));
    }

    public function remove($id)
    {
        $category = Category::find($id);
        $category->products()->delete();
        $category->delete();
        return redirect()->back();
    }
}