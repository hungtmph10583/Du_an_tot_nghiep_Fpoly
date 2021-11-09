<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ModelHasRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function accountInfo (){
        return view('client.customer.account-info');
    }

    public function updateinfo(){
        $model = User::find(Auth::user()->id);
        $model->load('model_has_role');

        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('client.customer.updateinfo', [
            'model' => $model,
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }

    public function saveUpdateinfo(Request $request){
        $model = User::find(Auth::user()->id);

        if(!$model){
            return redirect()->back();
        }
        
        $request->validate(
            [
                'name' => 'required|min:3|max:32',
                'email' => 'required|email',
                'phone' => 'max:10',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg',
            ],
            [
                'name.required' => "Hãy nhập vào tên",
                'email.required' => "Hãy nhập email",
                'email.email' => "Không đúng định dạng email",
                'phone.numeric' => "Số điện thoại không đúng định dạng",
                'phone.max' => "Số điện thoại chỉ có 10 chữ số",
                'uploadfile.mimes' => 'File ảnh đại diện không đúng định dạng (jpg, bmp, png, jpeg)',
            ]
        );

        $model->fill($request->all());
        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->avatar = $request->file('uploadfile')->storeAs('uploads/users', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();

        if($request->has('role_id')){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $model->assignRole($request->role_id);
        }
        
        return redirect(route('user.index'));
    }

    public function proFile($id){
        $user = User::find($id);
        $user->load('model_has_role');

        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('admin.user.pro-file', [
            'user' => $user,
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }
}
