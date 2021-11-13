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

class BlogController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.blog.index');
    }

    public function getData(Request $request)
    {
        $category = Blog::select('blogs.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
            ->orderColumn('category_blog_id', function ($row, $order) {
                return $row->orderBy('category_blog_id', $order);
            })
            ->addColumn('category_blog_id', function ($row) {
                return $row->BlogCategory->name;
            })
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
                        $w->orWhere('title', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function addForm()
    {
        $categoryBlog = BlogCategory::all();
        return view('admin.blog.add-form', compact('categoryBlog'));
    }

    public function upload(Request $request)
    {
        $uploadImg = $request->file('file')->store('images', 'public');
        return json_encode(['location' => "/storage/$uploadImg"]);
    }

    public function saveAdd(Request $request, $id = null)
    {
        $model = new Blog();
        $message = [
            'title.required' => "Hãy nhập vào chủ đề bài viết",
            'title.unique' => "Tên chủ đề bài viết đã tồn tại",
            'category_blog_id.required' => "Hãy chọn danh mục",
            'status' => 'Hãy chọn trạng thái bài viết',
            'content' => 'Hãy nhập nội dung bài viết',
            'image.required' => 'Hãy chọn ảnh bài viết',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'title' => [
                    'required',
                    Rule::unique('blogs')->ignore($id)
                ],
                'category_blog_id' => 'required',
                'status' => 'required',
                'content' => 'required',
                'image' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());
            $model->user_id = Auth::user()->id;
            if ($request->has('image')) {
                $model->image = $request->file('image')->storeAs(
                    'uploads/blog/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }

            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/tin-tuc')]);
    }

    public function editForm($id)
    {
        $model = Blog::find($id);
        $categoryBlog = BlogCategory::all();

        if (!$model) {
            return redirect()->back();
        }
        return view('admin.blog.edit-form', compact('model', 'categoryBlog'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = Blog::find($id);
        if (!$model) {
            return redirect()->back();
        }
        $message = [
            'title.required' => "Hãy nhập vào chủ đề bài viết",
            'title.unique' => "Tên chủ đề bài viết đã tồn tại",
            'category_blog_id.required' => "Hãy chọn danh mục",
            'status' => 'Hãy chọn trạng thái bài viết',
            'content' => 'Hãy nhập nội dung bài viết',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'title' => [
                    'required',
                    Rule::unique('blogs')->ignore($id)
                ],
                'category_blog_id' => 'required',
                'status' => 'required',
                'content' => 'required',
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());

            $model->user_id = Auth::user()->id;
            if ($request->has('image')) {
                $model->image = $request->file('image')->storeAs(
                    'uploads/blog/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/tin-tuc')]);
    }

    public function detail($id)
    {
        $blog = Blog::find($id);

        return view('admin.blog.detail', compact('blog'));
    }

    public function remove($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->back();
    }
}