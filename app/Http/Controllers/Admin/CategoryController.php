<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Product;
use App\Models\Breed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.category.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $category = Category::select('categories.*')->with('categoryType');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
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
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('category.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        $categoryType = CategoryType::all();
        return view('admin.category.add-form', compact('categoryType'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        if ($request->name) {
            $dupicate = Category::onlyTrashed()
                ->where('name', 'like', $request->name)->first();
        } else {
            $dupicate = null;
        }

        $message = [
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên danh mục đã tồn tại",
            'name.regex' => "Tên danh mục không chứa kí tự đặc biệt và số",
            'name.min' => "Tên danh mục ít nhất 3 kí tự",
            'category_type_id.required' => "Hãy chọn danh mục",
            'show_slide.required' => "Hãy chọn trạng thái danh mục",
            'uploadfile.required' => 'Hãy chọn ảnh danh mục',
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Category::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Danh mục đã tồn tại trong thùng rác .
                             Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    }
                ],
                'category_type_id' => 'required',
                'show_slide' => 'required',
                'uploadfile' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('category.index'), 'dupicate' => $dupicate]);
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
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('category.index'), 'message' => 'Thêm sản phẩm thành công']);
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
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên danh mục đã tồn tại",
            'name.regex' => "Tên danh mục không chứa kí tự đặc biệt và số",
            'name.min' => "Tên danh mục ít nhất 3 kí tự",
            'category_type_id.required' => "Hãy chọn danh mục",
            'show_slide.required' => "Hãy chọn trạng thái danh mục",
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Category::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Danh mục đã tồn tại trong thùng rác .
                             Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    }
                ],
                'category_type_id' => 'required',
                'show_slide' => 'required',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('category.index')]);
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
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('category.index'), 'message' => 'Sửa sản phẩm thành công']);
    }

    public function detail($id)
    {
        $category = Category::find($id);
        if (!$category) {
            $category = Category::onlyTrashed()->find($id);
            $category->load('products', 'breeds');
        }
        $category->load('products', 'breeds');

        $product = Product::all();
        $breed = Breed::all();

        return view('admin.category.detail', compact('category', 'product', 'breed'));
    }

    public function backUp()
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.category.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $category = Category::onlyTrashed()->select('categories.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_type_id', function ($row, $order) {
                return $row->orderBy('category_type_id', $order);
            })
            ->addColumn('category_type_id', function ($row) {
                return $row->categoryType->name;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('category.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('category.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $category = Category::find($id);

        if ($category->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục thất bại !']);
        }

        $pro = $category->products();
        $pro->each(function ($galleries) {
            $galleries->galleries()->delete();
        });
        $pro->delete();
        $category->delete();

        return response()->json(['success' => 'Xóa thú cưng thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category->count() == 0) {
            return response()->json(['success' => 'Sản phẩm không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại danh muc']);
        }

        $pro = $category->products();
        $pro->each(function ($galleries) {
            $galleries->galleries()->restore();
        });
        $pro->restore();
        $category->restore();

        return response()->json(['success' => 'Khôi phục thú cưng thành công !']);
    }

    public function delete($id)
    {
        $category = Category::withTrashed()->where('id', $id);

        if ($category->count() == 0) {
            return response()->json(['success' => 'Sản phẩm không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại danh mucj']);
        }

        $category->each(function ($product) {
            $pro = $product->products();
            $pro->each(function ($galleries) {
                $galleries->galleries()->forceDelete();
            });
            $pro->forceDelete();
        });
        $category->forceDelete();

        return response()->json(['success' => 'Xóa danh mục thành công !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $category = Category::withTrashed()->whereIn('id', $idAll);

        if ($category->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục thất bại !']);
        }

        $category->each(function ($product) {
            $pro = $product->products();
            $pro->each(function ($galleries) {
                $galleries->galleries()->delete();
            });
            $pro->delete();
        });
        $category->delete();

        return response()->json(['success' => 'Xóa danh mục thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $category = Category::withTrashed()->whereIn('id', $idAll);

        if ($category->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục thất bại !']);
        }

        $category->each(function ($product) {
            $pro = $product->products();
            $pro->each(function ($galleries) {
                $galleries->galleries()->restore();
            });
            $pro->restore();
        });
        $category->restore();

        return response()->json(['success' => 'Khôi phục danh mục thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $category = Category::withTrashed()->whereIn('id', $idAll);

        if ($category->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục thất bại !']);
        }

        $category->each(function ($product) {
            $pro = $product->products();
            $pro->each(function ($galleries) {
                $galleries->galleries()->forceDelete();
            });
            $pro->forceDelete();
        });
        $category->forceDelete();

        return response()->json(['success' => 'Xóa danh mục danh mục thành công !']);
    }
}