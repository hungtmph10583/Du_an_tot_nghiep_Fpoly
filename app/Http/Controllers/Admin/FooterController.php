<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\FooterTitle;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class FooterController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.footer.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $footer = Footer::select('footers.*');
        return dataTables::of($footer)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })

            ->addColumn('footerTitle', function ($row) {
                return $row->footerTitle->map(function ($al) {
                    return $al->name;
                })->implode(' ');
            })
            ->addColumn('generalSetting', function ($row) {
                return $row->generalSetting->map(function ($al) {
                    return $al->phone;
                })->implode(' ');
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('footer.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a  class="btn btn-success" href="' . route('footer.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('footer.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('content', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        $footer = Footer::get();
        $footerTitle = FooterTitle::get();
        $general = GeneralSetting::get();
        return view('admin.footer.add-form', compact('footer', 'footerTitle', 'general'));
    }

    public function saveAdd(Request $request, $id = null)
    {

        $message = [
            'content.required' => "Hãy nhập vào tiêu đề",
            'content.regex' => "Tiêu đề không chứa kí tự đặc biệt và số",
            'content.min' => "Tiêu đề ít nhất 3 kí tự",
            'content.unique' => "Tiêu đề đã tồn tại",
            'type.required' => "Hãy nhập kiểu",
            'type.numeric' => "Kiểu là số",
            'footer_title_id.required' => "Hãy chọn tiêu đề",
            'general_setting_id.required' => "Hãy chọn cài đặt chung",
            'icon.required' => 'Hãy chọn ảnh danh mục',
            'icon.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'icon.max' => 'File ảnh không được quá 2MB',
            'url.url' => "Đường dẫn không hợp lệ"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'content' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('footers')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Footer::onlyTrashed()
                            ->where('content', 'like', '%' . $request->content . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->content) {
                                return $fail('Nội dung đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'type' => 'required|numeric',
                'footer_title_id' => 'required',
                'general_setting_id' => 'required',
                'icon' => 'required|mimes:jpg,bmp,png,jpeg|max:2048',
                'url' => 'nullable|url'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('footer.index')]);
        } else {
            $model = new Footer();
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('footer.index'), 'message' => 'Thêm footer thành công']);
    }

    public function editForm($id)
    {
        $model = Footer::find($id);
        if (!$model) {
            return redirect()->back();
        }
        $footerTitle = FooterTitle::get();
        $general = GeneralSetting::get();
        return view('admin.footer.edit-form', compact('model', 'footerTitle', 'general'));
    }

    public function saveEdit($id, Request $request)
    {

        $model = Footer::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'content.required' => "Hãy nhập vào tiêu đề",
            'content.regex' => "Tiêu đề không chứa kí tự đặc biệt và số",
            'content.min' => "Tiêu đề ít nhất 3 kí tự",
            'content.unique' => "Tiêu đề đã tồn tại",
            'type.required' => "Hãy nhập kiểu",
            'type.numeric' => "Kiểu là số",
            'footer_title_id.required' => "Hãy chọn tiêu đề",
            'general_setting_id.required' => "Hãy chọn cài đặt chung",
            'icon.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'icon.max' => 'File ảnh không được quá 2MB',
            'url.url' => "Đường dẫn không hợp lệ"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'content' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('footers')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Footer::onlyTrashed()
                            ->where('content', 'like', '%' . $request->content . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->content) {
                                return $fail('Nội dung đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'type' => 'required|numeric',
                'general_setting_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $general_setting = GeneralSetting::where('id', $request->general_setting_id)->first();
                        if ($general_setting == '') {
                            return $fail('Cài đặt hệ thống không tồn tại');
                        }
                    },
                ],
                'icon' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'url' => 'nullable|url'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('footer.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('footer.index'), 'message' => 'Sửa chân trang thành công']);
    }

    public function detail($id)
    {
        $model = Footer::find($id);

        return view('admin.footer.detail', compact('model'));
    }

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.footer.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $footer = Footer::onlyTrashed()->select('footers.*');
        return dataTables::of($footer)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('footerTitle', function ($row) {
                return $row->footerTitle->map(function ($al) {
                    return $al->name;
                })->implode(' ');
            })
            ->addColumn('generalSetting', function ($row) {
                return $row->generalSetting->map(function ($al) {
                    return $al->phone;
                })->implode(' ');
            })
            ->orderColumn('footerTitle', function ($row, $order) {
                return $row
                    ->orderBy('footer_title_id', $order);
            })
            ->orderColumn('generalSetting', function ($row, $order) {
                return $row
                    ->orderBy('general_setting_id', $order);
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('footer.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('footer.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('content', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $footer = Footer::withTrashed()->find($id);
        if (empty($footer)) {
            return response()->json(['success' => 'Tiêu đề chân trang không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tiêu đề chân trang']);
        }

        $footer->delete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $footer = Footer::withTrashed()->find($id);
        if (empty($footer)) {
            return response()->json(['success' => 'Tiêu đề chân trang không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tiêu đề chân trang']);
        }
        $footer->restore();
        return response()->json(['success' => 'Khôi phục tiêu đề chân trang thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $footer = Footer::withTrashed()->find($id);
        if (empty($footer)) {
            return response()->json(['success' => 'Tiêu đề chân trang không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tiêu đề chân trang']);
        }

        $footer->forceDelete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $footer = Footer::withTrashed()->whereIn('id', $idAll);

        if ($footer->count() == 0) {
            return response()->json(['success' => 'Xóa tiêu đề chân trang thất bại !']);
        }

        $footer->delete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $footer = Footer::withTrashed()->whereIn('id', $idAll);

        if ($footer->count() == 0) {
            return response()->json(['success' => 'Khôi phục tiêu đề chân trang thất bại !']);
        }

        $footer->restore();
        return response()->json(['success' => 'Khôi phục tiêu đề chân trang thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $footer = Footer::withTrashed()->whereIn('id', $idAll);

        if ($footer->count() == 0) {
            return response()->json(['success' => 'Khôi phục tiêu đề chân trang thất bại !']);
        }

        $footer->forceDelete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !']);
    }
}