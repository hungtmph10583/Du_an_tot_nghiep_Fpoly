<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\FooterTitle;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class FooterTitleController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.footerTitle.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $footerTitle = FooterTitle::select('footer_titles.*');
        return dataTables::of($footerTitle)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('footerTitle.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a  class="btn btn-success" href="' . route('footerTitle.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('footerTitle.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        return view('admin.footerTitle.add-form', compact('footer'));
    }

    public function saveAdd(Request $request, $id = null)
    {

        $message = [
            'name.required' => "Hãy nhập vào tiêu đề",
            'name.alpha' => "Tiêu đề phải là chữ",
            'name.unique' => "Tiêu đề đã tồn tại",
            'status.required' => "Hãy chọn trạng thái"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'alpha',
                    Rule::unique('footer_titles')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = FooterTitle::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tiêu đề đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'status' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('footerTitle.index')]);
        } else {
            $model = new FooterTitle();
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('footerTitle.index'), 'message' => 'Thêm tiêu đề thành công']);
    }

    public function editForm($id)
    {
        $model = FooterTitle::find($id);
        if (!$model) {
            return redirect()->back();
        }

        return view('admin.footerTitle.edit-form', compact('model'));
    }

    public function saveEdit($id, Request $request)
    {

        $model = FooterTitle::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào tiêu đề",
            'name.alpha' => "Tiêu đề phải là chữ",
            'name.unique' => "Tiêu đề đã tồn tại",
            'status.required' => 'Hãy chọn trạng thái'
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'alpha',
                    Rule::unique('footer_titles')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = FooterTitle::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tiêu đề đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'status' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('footerTitle.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('footerTitle.index'), 'message' => 'Sửa tiêu đề thành công']);
    }

    public function detail($id)
    {
        $model = FooterTitle::find($id);
        $model->load('products');

        $product = Product::all();
        // $category = Category::all();

        return view('admin.footerTitle.detail', compact('product', 'model'));
    }

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.footerTitle.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $footerTitle = FooterTitle::onlyTrashed()->select('footer_titles.*');
        return dataTables::of($footerTitle)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('footerTitle.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('footerTitle.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        $footerTitle = FooterTitle::withTrashed()->find($id);
        if (empty($footerTitle)) {
            return response()->json(['success' => 'Tiêu đề chân trang không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tiêu đề chân trang']);
        }

        $footerTitle->footer()->delete();
        $footerTitle->delete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $footerTitle = FooterTitle::withTrashed()->find($id);
        if (empty($footerTitle)) {
            return response()->json(['success' => 'Tiêu đề chân trang không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tiêu đề chân trang']);
        }
        $footerTitle->footer()->restore();
        $footerTitle->restore();
        return response()->json(['success' => 'Khôi phục tiêu đề chân trang thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $footerTitle = FooterTitle::withTrashed()->find($id);
        if (empty($footerTitle)) {
            return response()->json(['success' => 'Tiêu đề chân trang không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tiêu đề chân trang']);
        }

        $footerTitle->footer()->forceDelete();
        $footerTitle->forceDelete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $footerTitle = FooterTitle::withTrashed()->whereIn('id', $idAll);

        if ($footerTitle->count() == 0) {
            return response()->json(['success' => 'Xóa tiêu đề chân trang thất bại !']);
        }

        $footerTitle->each(function ($footer) {
            $footer->footer()->delete();
        });
        $footerTitle->delete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $footerTitle = FooterTitle::withTrashed()->whereIn('id', $idAll);

        if ($footerTitle->count() == 0) {
            return response()->json(['success' => 'Khôi phục tiêu đề chân trang thất bại !']);
        }

        $footerTitle->each(function ($footer) {
            $footer->footer()->restore();
        });
        $footerTitle->restore();
        return response()->json(['success' => 'Khôi phục tiêu đề chân trang thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $footerTitle = FooterTitle::withTrashed()->whereIn('id', $idAll);

        if ($footerTitle->count() == 0) {
            return response()->json(['success' => 'Khôi phục tiêu đề chân trang thất bại !']);
        }

        $footerTitle->each(function ($footer) {
            $footer->footer()->forceDelete();
        });
        $footerTitle->forceDelete();
        return response()->json(['success' => 'Xóa tiêu đề chân trang thành công !']);
    }
}