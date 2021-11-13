<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.blogCategory.index');
    }

    public function addForm()
    {
        return view('admin.blogCategory.add-form');
    }

    public function getData(Request $request)
    {
        $category = BlogCategory::select('blog_categories.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('blog.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a href="' . route('blog.edit', ['id' => $row->id]) . '" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                    <a class="btn btn-outline-danger"href="' . route('blog.remove', ['id' => $row->id]) . '"><i class="far fa-trash-alt"></i></a>
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

    public function saveAdd(Request $request, $id = null)
    {
        $model = new BlogCategory();
        $message = [
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên danh mục đã tồn tại",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('blog_categories')->ignore($id)
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/danh-muc-tin-tuc')]);
    }
    public function editForm($id)
    {
        $model = BlogCategory::find($id);

        if (!$model) {
            return redirect()->back();
        }
        return view('admin.blogCategory.edit-form', compact('model'));
    }
    public function saveEdit($id, Request $request)
    {
        $model = BlogCategory::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên danh mục đã tồn tại",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('blog_categories')->ignore($id)
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());

            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/danh-muc-tin-tuc')]);
    }
}