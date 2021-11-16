<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;

class GeneralSettingController extends Controller
{
    public function index(){
        $model = GeneralSetting::find(1);
        // dd($model);
        if(!$model){
            return redirect()->back();
        }
        return view('admin.generalSetting.index', compact('model'));
    }
    public function save(Request $request){
        $model = GeneralSetting::find(1); 
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());
        
        if($request->has('uploadfile')){
            $model->logo =$request->file('uploadfile')->storeAs('uploads/logo/', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
            $model->save();
        }
        $model->save();
        return redirect(route('generalSetting.index'));
    }

    public function footer(){
        $model = GeneralSetting::find(1);
        // dd($model);
        if(!$model){
            return redirect()->back();
        }
        return view('admin.generalSetting.footer', compact('model'));
    }
}
