<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Product;
use App\Models\Breed;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.category.index');
    }

    public function getData(Request $request)
    {
        $category = Category::select('categories.*')->with('categoryType');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
            ->orderColumn('category_type_id', function ($row, $order) {
                return $row->orderBy('category_type_id', $order);
            })
            ->addColumn('category_type_id', function ($row) {
                return $row->categoryType->name;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                <a href="' . route('category.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                <a  class="btn btn-success" href="' . route('category.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                                    </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function addForm()
    {
        $categoryType = CategoryType::all();
        return view('admin.category.add-form', compact('categoryType'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'name.required' => "Hãy nhập vào tên danh mục",
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

    public function saveEdit($id, Request $request)
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
        if (!$category) {
            $category = Category::onlyTrashed()->find($id);
        }
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
        return response()->json(['success' => 'Xóa thú cưng thành công !']);
    }

    public function backUp()
    {
        return view('admin.category.back-up');
    }

    public function getBackUp(Request $request)
    {
        $category = Category::onlyTrashed();
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
            ->orderColumn('category_type_id', function ($row, $order) {
                return $row->orderBy('category_type_id', $order);
            })
            ->addColumn('category_type_id', function ($row) {
                return $row->categoryType->name;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                <a href="' . route('category.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                <a  class="btn btn-success" href="javascript:void(0);" onclick="restoreData(' . $row->id . ')"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                                    </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function restore($id)
    {
        $category = Category::withTrashed();
        $category->find($id)->products()->restore();
        $category->restore();
        return response()->json(['success' => 'Xóa thú cưng thành công !']);
    }

    public function delete($id)
    {
    }
}