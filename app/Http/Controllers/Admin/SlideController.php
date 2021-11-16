<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Auth;

class SlideController extends Controller
{
    public function index(){
        $pagesize = 7;
        $slide = Slide::paginate($pagesize);
        return view('admin.slide.index', [
            'slide' => $slide
        ]);
    }

    public function addForm(){
        return view('admin.slide.add-form');
    }

    public function saveAdd(Request $request){
        $model = new Slide();
        $model->fill($request->all());

        $model->user_id = Auth::user()->id;
        if($request->has('uploadfile')){
            $model->image = $request->file('uploadfile')->storeAs('uploads/slide/' . $model->id , 
                                    uniqid() . '-' . $request->uploadfile->getClientOriginalName());
            $model->save();
        }
        $model->save();
        
        return redirect(route('slide.index'));
    }

    public function editForm($id){
        $slide = Slide::find($id);
        return view('admin.slide.edit-form', compact('slide'));
    }

    public function saveEdit($id,Request $request){
        $model = Slide::find($id); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());

        $model->user_id = Auth::user()->id;
        if($request->has('uploadfile')){
            $model->image =$request->file('uploadfile')->storeAs('uploads/slide/' . $model->id , 
                                    uniqid() . '-' . $request->uploadfile->getClientOriginalName());
            $model->save();
        }

        $model->save();
        return redirect(route('slide.index'));
    }

    public function remove($id){
        $slide = Slide::find($id);
        $slide->delete();
        return redirect()->back();
    }
}
