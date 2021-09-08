<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Book;
use App\Http\Requests\CategoryFormRequest;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $pagesize = config('common.default_page_size');
        $cateQuery = Category::where('name', 'like', "%".$request->keyword."%");
        if($request->has('order_by') && $request->order_by > 0){
            if($request->order_by == 1){
                $cateQuery->orderBy('name');
            }else if($request->order_by == 2){
                $cateQuery->orderByDesc('name');
            }else if($request->order_by == 3){
                $cateQuery->orderBy('status');
            }else if($request->order_by == 4){
                $cateQuery->orderByDesc('status');
            }else if($request->order_by == 5){
                $cateQuery->orderBy('show_menu');
            }else{
                $cateQuery->orderByDesc('show_menu');
            }
        }
        // nhận dữ liệu từ form gửi lên & thực hiện filter
        $books = Book::all();
        $cate = $cateQuery->get();
        $cate  = $cateQuery->paginate($pagesize);
        $cate->load('books');
        return view(
            'admin.category.index',
            [
                'cate' => $cate,
                'books' => $books,
            ]
        );
    }
    public function addForm(Request $request)
    {
        $cate = Category::all();
        return view('admin.category.add-form', compact('cate'));
    }
    public function saveAdd(CategoryFormRequest $request)
    {
        $model = new Category();
        $model->fill($request->all());
        if ($request->hasFile('file_upload')) {
            $newFileName = uniqid() . '-' . $request->file_upload->getClientOriginalName();
            $path = $request->file_upload->storeAs('public/uploads/images', $newFileName);
            $model->image = str_replace('public/', '', $path);
        }
        $model->save();
        return redirect(route('category.index'));
    }
    public function remove($id)
    {
        Book::where('cate_id', $id)->delete();
        // Xóa danh mục thì sản phẩm cũng bị xóa khi trùng danh mục xóa
        Category::where('id', $id)->delete();
        return redirect()->back();
    }
    public function editForm($id)
    {
        $cate = Category::find($id);
        if (!$cate) {
            return redirect()->back();
        }
        return view('admin.category.edit-form', compact('cate'));
    }

    public function saveEdit($id, CategoryFormRequest $request)
    {
        $model = Category::find($id);
        if (!$model) {
            return redirect(route('category.index'));
        }
        $model->fill($request->all());
        if ($request->hasFile('file_upload')) {
            $newFileName = uniqid() . '-' . $request->file_upload->getClientOriginalName();
            $path = $request->file_upload->storeAs('public/uploads/images', $newFileName);
            $model->image = str_replace('public/', '', $path);
        }
        $model->save();
        return redirect(route('category.index'));
    }
}
