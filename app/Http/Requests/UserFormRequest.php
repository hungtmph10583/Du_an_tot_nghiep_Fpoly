<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ruleArr =  [
            'name' => [
                'required',
                Rule::unique('users')->ignore($this->id)
            ],
            'email' => 'required|email',
            'uploadfile' => 'required',
            'password' => 'required|min:6|max:32',
            'cfpassword' => 'required|same:password|',
            'phone' => 'required|numeric'
        ];
        if($this->id == null){
            $ruleArr['uploadfile'] = 'required|mimes:jpg,bmp,png,jpeg';
        }else{
            $ruleArr['uploadfile'] = 'mimes:jpg,bmp,png,jpeg';
        }
        return $ruleArr;
    }

    public function messages(){
        return [
            'name.required' => "Hãy nhập vào tên",
            'name.unique' => "Tên đã tồn tại",
            'email.required' => "Hãy nhập email",
            'email.email' => "Không đúng định dạng email",
            'uploadfile.required' => 'Hãy chọn ảnh đại diện',
            'uploadfile.mimes' => 'File ảnh đại diện không đúng định dạng (jpg, bmp, png, jpeg)',
            'password.required' => "Hãy nhập mật khẩu",
            'password.min' => "Mật khẩu phải hơn 6 ký tự",
            'password.max' => "Mật khẩu phải dưới 32 ký tự",
            'cfpassword.required' => "Hãy nhập xác nhận mật khẩu",
            'cfpassword.same' => "Mật khẩu xác nhận không giống mật khẩu",
            'phone.required' => "Hãy nhập số điện thoại",
            'phone.numeric' => "Số điện thoại không đúng định dạng"
        ];
    }
}