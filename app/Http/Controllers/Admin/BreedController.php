<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class BreedController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.breed.index');
    }

    public function getData(Request $request)
    {
        $breed = Breed::select('breeds.*')->with('category');
        return dataTables::of($breed)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
            ->orderColumn('cate_id', function ($row, $order) {
                return $row->orderBy('category_id', $order);
            })
            ->orderColumn('status', function ($row, $order) {
                return $row->orderBy('status', $order);
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-primary">Active</span>';
                } elseif ($row->status == 0) {
                    return '<span class="badge badge-danger">Deactive</span>';
                } else {
                    return '<span class="badge badge-danger">Sắp ra mắt</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                <a href="' . route('breed.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                <a  class="btn btn-success" href="' . route('breed.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                                    </span>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '3') {
                    $instance->where('status', $request->get('status'));
                }

                if ($request->get('cate') != '') {
                    $instance->where('category_id', $request->get('cate'));
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
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