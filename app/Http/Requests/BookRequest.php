<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
                Rule::unique('books')->ignore($this->id)
            ],
            'cate_id' => 'required',
            'country_id' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
            'quantity' => 'required|numeric',
            'genres' => 'required',
            'author' => 'required',
            'galleries.*' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
        ];
        if ($this->id == null) {
            $ruleArr['image'] = 'required|mimes:jpg,bmp,png,jpeg|max:2048';
        } else {
            $ruleArr['image'] = 'mimes:jpg,bmp,png,jpeg|max:2048';
        }
        return $ruleArr;
    }

    public function messages()
    {
        return [
            'name.required' => "Hãy nhập vào tên sách",
            'name.unique' => "Tên sách đã tồn tại",
            'cate_id.required' => "Hãy chọn danh mục",
            'country_id.required' => "Hãy chọn quốc gia",
            'image.required' => 'Hãy chọn ảnh sách',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
            'price.required' => "Hãy nhập giá sách",
            'price.numeric' => "Giá sách phải là số",
            'quantity.required' => "Hãy nhập số lượng sách",
            'quantity.numeric' => "Số lượng sách phải là số",
            'status.required' => "Hãy chọn trạng thái sách",
            'genres.required' => "Hãy chọn thể loại sách",
            'author.required' => "Hãy chọn tác giả sách",
            'galleries.required' => "Hãy chọn thư viện ảnh cho sách",
            'galleries.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'galleries.max' => 'File ảnh không được quá 2MB',
        ];
    }
}