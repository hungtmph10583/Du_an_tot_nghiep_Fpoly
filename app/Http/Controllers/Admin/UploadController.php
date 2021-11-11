<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $uploadImg = $request->file('file');
        $filename = time() . '.' . $uploadImg->extension();
        Image::make($uploadImg)->save(public_path('images/' . $filename));
        return json_encode(['location' => asset('images/' . $filename)]);
    }
}