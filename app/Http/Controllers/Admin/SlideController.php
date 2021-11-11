<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SlideController extends Controller
{
    public function index(Request $request)
    {
        $model = Slide::find(1);
        // dd($model);
        return view('admin.slide.index', compact('model'));
    }
    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'image.required' => 'Hãy chọn ảnh người dùng',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
            'email.required' => 'Hãy nhập tài khoản Email',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Hãy nhập số điện thoại',
            'phone.min' => 'Số điện thoại có độ dài nhỏ nhất là 10 ký tự',
            'phone.max' => 'Số điện thoại có độ dài lớn nhất là 11 ký tự',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'phone' => [
                    'required',
                    Rule::unique('slide')->ignore($id),
                    'min:10',
                    'max:11',
                    'regex:/(0)[0-9]{8,9}/'
                ],
                'email' => [
                    'required',
                    Rule::unique('slide')->ignore($id),
                    'email',
                ],
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048',
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model = new Slide();

            $model->fill($request->all());

            // upload ảnh
            if ($request->hasFile('image')) {
                $model->avatar = $request->file('image')->storeAs('uploads/users', uniqid() . '-' . $request->image->getClientOriginalName());
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/tai-khoan')]);
    }
}