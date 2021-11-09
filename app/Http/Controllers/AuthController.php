<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm(Request $request){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        // thực hiện validate bằng $request
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => "Hãy nhập vào Email!",
                'email.email' => "Email không đúng định dạng!",
                'password.required' => "Hãy nhập vào mật khẩu!"
            ]
        );

        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email' => $email, 'password' => $password, 'status' => 0])){    
            return redirect()->back()->with('msg', "Tài khoản của bạn đang bị khóa, liên hệ Huy Phan để mở!");
        }elseif(Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
            return redirect(route('client.home'));
        } else {
            return redirect()->back()->with('msg', "Email hoặc mật khẩu không chính xác!");
        }
    }

    public function registrationForm(){
        return view('auth.registration');
    }

    public function saveRegistration(Request $request){
        $users = User::all();
        $request->validate(
            [
                'name' => 'required|min:3|max:32',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|max:32',
                'cfpassword' => 'required|same:password|'
            ],
            [
                'name.required' => "Hãy nhập vào tên",
                'email.required' => "Hãy nhập email",
                'email.email' => "Không đúng định dạng email",
                'email.unique' => "Email này đã được sử dụng",
                'password.required' => "Hãy nhập mật khẩu",
                'password.min' => "Mật khẩu phải hơn 6 ký tự",
                'password.max' => "Mật khẩu phải dưới 32 ký tự",
                'cfpassword.required' => "Hãy nhập xác nhận mật khẩu",
                'cfpassword.same' => "Mật khẩu xác nhận không giống mật khẩu"
            ]
        );
        $model = new User();
        $model->fill($request->all());
        $model->password = Hash::make($request->password);
        $model->save();

        //return redirect(route('login'));
        return redirect()->back()->with("success","Tạo tài khoản thành công. Quay lại trang Sign in để đăng nhập!");
    }

    public function forgotPassword(Request $request){
        return view('auth.forgot-password');
    }

    public function saveForgotPassword(){
        return redirect(route('login'));
    }

    public function changePassword(Request $request){
        return view('auth.change-password');
    }

    public function saveChangePassword(Request $request){
        $request->validate(
            [
                'email' => 'required|email',
                'currentpassword' => 'required',
                'newpassword' => 'required',
                'cfpassword' => 'required|same:newpassword|'
            ],
            [
                'email.required' => "Hãy nhập email",
                'email.email' => "Không đúng định dạng email",
                'currentpassword.required' => "Hãy nhập mật khẩu",
                'newpassword.required' => "Hãy nhập mật khẩu mới",
                'cfpassword.required' => "Hãy nhập xác nhận mật khẩu",
                'cfpassword.same' => "Mật khẩu xác nhận không giống mật khẩu"
            ]
        );

        if (!(Hash::check($request->get('currentpassword'), Auth::user()->password))) {
            return redirect()->back()->with("error","Mật khẩu hiện tại bạn nhập không khớp. Vui lòng thử lại!");
        }
        if(strcmp($request->get('currentpassword'), $request->get('newpassword')) == 0){
            return redirect()->back()->with("error","Mật khẩu mới không được giống với mật khẩu hiện tại!");
        }
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->newpassword);
        $user->save();

        return redirect()->back()->with("success","Mật khẩu của bạn đã được thay đổi !");
    }


    /*
     * 28/29/21
    */
    
    // public function regeister(Request $request) {
    //     $fields = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|string|unique:users,email',
    //         'password' => 'required|string|confirmed'
    //     ]);

    //     $user = User::create([
    //         'name' => $fields['name'],
    //         'email' => $fields['email'],
    //         'password' => bcrypt($fields['password'])
    //     ]);
    //     $token = $user->createToken('myapptoken')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];
    //     return response($response, 201);
    // }

    // public function login(Request $request){
    //     $fields = $request->validate([
    //         'email' => 'required|string',
    //         'password' => 'required|string'
    //     ]);
    //     // Check email
    //     $user = User::where('email', $fields['email'])->first();

    //     // Check password
    //     if (!$user || !Hash::check($fields['password'], $user->password)) {
    //         return response([
    //             'message' => 'Bad creds'
    //         ], 401);
    //     }

    //     $token = $user->createToken('myapptoken')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];
    //     return response($response, 201);
    // }

    // public function logout(Request $request){
    //     auth()->user()->tokens()->delete();
    //     return [
    //         'message' => 'Say bye bye'
    //     ];
    // }
}
