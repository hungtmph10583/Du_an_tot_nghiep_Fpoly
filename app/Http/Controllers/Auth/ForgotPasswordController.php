<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Mail;
use DB;

class ForgotPasswordController extends Controller
{
    public function getEmail(){
       return view('auth.password.email');
    //    return view('auth.forgot-password');
    }

    public function postEmail(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ],
        [
            'email.required' => "Hãy nhập vào địa chỉ Email!",
            'email.email' => "Email không đúng định dạng!",
            'email.exists' => "Không tìm thấy tài khoản!"
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('auth.password.verify',['token' => $token], function($message) use ($request) {
            $message->from($request->email);
            $message->to($request->email);
            $message->subject('Thông báo đặt lại mật khẩu!');
        });
        return back()->with('message', 'Chúng tôi đã sử dụng email liên kết để dặt lại mặt khẩu của bạn. Vui lòng kiểm tra email!');
    }
}