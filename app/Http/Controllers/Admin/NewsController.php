<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index(Request $request){
        $pagesize = 7;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách tin tức & phân trang cho nó
            $news = News::paginate($pagesize);
        }
        
        // trả về cho người dùng 1 giao diện + dữ liệu categories vừa lấy đc 
        return view('admin.news.index', [
            'news' => $news,
            'searchData' => $searchData
        ]);
    }

    public function addForm(){
        return view('admin.news.add-form');
    }
}
