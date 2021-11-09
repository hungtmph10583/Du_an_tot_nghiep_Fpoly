<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;

class SlideController extends Controller
{
    public function index(Request $request){
        $model = Slide::find(1);
        // dd($model);
        return view('admin.slide.index', compact('model'));
    }
}
