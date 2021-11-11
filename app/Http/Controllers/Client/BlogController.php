<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index(Request $request){
        $pagesize = 8;
        $searchData = $request->except('page');
        
        if (count($request->all()) == 0) {
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $blog = Blog::paginate($pagesize);
        } else {
            $blogQuery = Blog::where('title', 'like', "%" . $request->keyword . "%");
            $blog = $blogQuery->paginate($pagesize)->appends($searchData);
        }
        
        return view('client.blog.index', [
            'blog' => $blog,
            'searchData' => $searchData
        ]);
    }

    public function detail($id, Request $request){
        $blog = Blog::find($id);
        $blog->load('blogCategory');

        $blogCategory = BlogCategory::all();

        return view('client.blog.detail', compact('blog', 'blogCategory'));
    }
}
