<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Address;
use App\Models\City;
use App\Models\ModelHasRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function accountInfo (){
        $model = User::find(Auth::user()->id);
        $model->load('address');
        return view('client.customer.account-info', compact('model'));
    }

    public function updateinfo(){
        $model = User::find(Auth::user()->id);

        $address = Address::all();
        // dd($address);
        $city = City::all();
        return view('client.customer.updateinfo', [
            'model' => $model,
            'address' => $address,
            'city' => $city
        ]);
    }

    public function saveUpdateinfo(Request $request){
        $user = Auth::user()->id;
        $model = User::find($user);
        if(!$model){
            return redirect()->back();
        }
        $request->validate(
            [
                'name' => 'required|min:3|max:32',
                'email' => 'required|email',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg',
            ],
            [
                'name.required' => "Hãy nhập vào tên",
                'email.required' => "Hãy nhập email",
                'email.email' => "Không đúng định dạng email",
                'uploadfile.mimes' => 'File ảnh đại diện không đúng định dạng (jpg, bmp, png, jpeg)',
            ]
        );

        $model->fill($request->all());
        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->avatar = $request->file('uploadfile')->storeAs('uploads/users', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();

        if($request->has('address')){
            $check = Address::where('user_id', $user)->get();
            if (!Address::where('user_id', $user)) {
                $city = City::find($request->city);
                $newaddress = new Address();
                $newaddress->user_id = $user;
                $newaddress->address = $request->address.", ".$request->ward.", ".$request->district.", ".$city->name;
                $newaddress->city_id = $request->city;
                $newaddress->save();
            }else{
                $city = City::find($request->city);
                $newaddress = Address::fint(Auth::user()->address->id);
                $newaddress->user_id = $user;
                $newaddress->address = $request->address.", ".$request->ward.", ".$request->district.", ".$city->name;
                $newaddress->city_id = $request->city;
                $newaddress->save();
            }
            // $city = City::find($request->city);
            // $newaddress = new Address();
            // $newaddress->user_id = $user;
            // $newaddress->address = $request->address.", ".$request->ward.", ".$request->district.", ".$city->name;
            // $newaddress->city_id = $request->city;
            // $newaddress->save();
        }
        return redirect(route('client.customer.info'));
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
