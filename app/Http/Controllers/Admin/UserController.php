<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ModelHasRole;
use Illuminate\Support\Facades\DB;

use App\Models\PersonalInformation;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $users = User::paginate($pagesize);
        }else{
            $userQuery = User::where('name', 'like', "%" .$request->keyword . "%");

            if($request->has('order_by') && $request->order_by > 0){
                if($request->order_by == 1){
                    $userQuery = $userQuery->orderBy('name');
                }else{
                    $userQuery = $userQuery->orderByDesc('name');
                }
            }
            $users = $userQuery->paginate($pagesize)->appends($searchData);
        }
        // trả về cho người dùng 1 giao diện + dữ liệu users vừa lấy đc 
        $users->load('model_has_role');

        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('admin.user.index', [
            'users' => $users,
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }

    public function addForm(){
        $role = Role::all();
        return view('admin.user.add-form', [
            'roles' => $role
        ]);
    }

    public function saveAdd(UserFormRequest $request){
        $model = new User();

        $model->fill($request->all());

        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->avatar = $request->file('uploadfile')->storeAs('uploads/users', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }

        /**
         * HungTM
         * Tao token
         * Start
         */
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet);

            for ($i=0; $i <= 10; $i++) {
                $token .= $codeAlphabet[rand(0, $max-1)];
            }
        /**
         * HungTM
         * Tao token
         * End
         */

        $model->password = Hash::make($request->password);
        $model->remember_token = $token;
        $model->save();

        // save quyen 
        if($request->has('role_id')){
            $model->assignRole($request->role_id);
        }
        return redirect(route('user.index'));
    }

    public function editForm($id){
        $model = User::find($id);
        $model->load('model_has_role');

        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('admin.user.edit-form', [
            'model' => $model,
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }

    public function saveEdit($id, Request $request){
        $model = User::find($id);

        if(!$model){
            return redirect()->back();
        }

        if($id == 1){
            if(Auth::user()->id != '1'){
                return redirect()->back()->with('msg', "Đã bảo là đéo đủ tuổi r còn cố :))");
            }
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
        $user->load('personal_information');
        $user->load('model_has_role');

        $psInfor = PersonalInformation::all();
        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('admin.user.pro-file', [
            'user' => $user,
            'psInfor' => $psInfor,
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }
}
