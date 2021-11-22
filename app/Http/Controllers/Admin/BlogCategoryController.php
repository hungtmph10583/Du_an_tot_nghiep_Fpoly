<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.blogCategory.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $category = BlogCategory::select('blog_categories.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('blog.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a href="' . route('blog.edit', ['id' => $row->id]) . '" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('blogCategory.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        return view('admin.blogCategory.add-form');
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

    public function backUp()
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.blogCategory.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $category = BlogCategory::onlyTrashed()->select('blog_categories.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('blogCategory.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('blogCategory.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        $blogCate = BlogCategory::withTrashed()->find($id);
        if (empty($blogCate)) {
            return response()->json(['success' => 'Danh mục bài viết không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }

        $blogCate->blogs()->delete();
        $blogCate->delete();
        return response()->json(['success' => 'Xóa danh mục bài viết thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $blogCate = BlogCategory::withTrashed()->find($id);
        if (empty($blogCate)) {
            return response()->json(['success' => 'Danh mục bài viết không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $blogCate->blogs()->restore();
        $blogCate->restore();
        return response()->json(['success' => 'Khôi phục danh mục bài viết thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $blogCate = BlogCategory::withTrashed()->find($id);
        if (empty($blogCate)) {
            return response()->json(['success' => 'Danh mục bài viết không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $blogCate->blogs()->forceDelete();
        $blogCate->forceDelete();
        return response()->json(['success' => 'Xóa danh mục bài viết thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blogCate = BlogCategory::withTrashed()->whereIn('id', $idAll);

        if ($blogCate->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục bài viết thất bại !']);
        }

        $blogCate->each(function ($blog) {
            $blog->blogs()->delete();
        });
        $blogCate->delete();
        return response()->json(['success' => 'Xóa danh mục bài viết thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blogCate = BlogCategory::withTrashed()->whereIn('id', $idAll);

        if ($blogCate->count() == 0) {
            return response()->json(['success' => 'Khôi phục danh mục bài viết thất bại !']);
        }

        $blogCate->each(function ($blog) {
            $blog->blogs()->restore();
        });
        $blogCate->restore();
        return response()->json(['success' => 'Khôi phục danh mục bài viết thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blogCate = BlogCategory::withTrashed()->whereIn('id', $idAll);

        if ($blogCate->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục bài viết thất bại !']);
        }

        $blogCate->each(function ($blog) {
            $blog->blogs()->forceDelete();
        });
        $blogCate->forceDelete();
        return response()->json(['success' => 'Xóa danh mục bài viết thành công !']);
    }
}