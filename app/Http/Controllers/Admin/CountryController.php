<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.country.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $category = Country::select('countries.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('country.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a href="' . route('country.edit', ['id' => $row->id]) . '" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('country.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('code', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        return view('admin.country.add-form');
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'name.required' => "Hãy nhập vào tên quốc gia",
            'name.unique' => "Tên quốc gia đã tồn tại",
            'code.required' => "Hãy nhập vào ký hiệu",
            'code.unique' => "Ký hiệu đã tồn tại",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('countries')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Country::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên quốc gia đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'code' => [
                    'required',
                    Rule::unique('countries')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Country::onlyTrashed()
                            ->where('code', 'like', '%' . $request->code . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->code) {
                                return $fail('Ký hiệu đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('country.index')]);
        } else {
            $model = new Country();
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('country.index'), 'message' => 'Thêm quốc gia thành công']);
    }

    public function editForm($id)
    {
        $model = Country::find($id);

        if (!$model) {
            return redirect()->back();
        }
        return view('admin.country.edit-form', compact('model'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = Country::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào tên quốc gia",
            'name.unique' => "Tên quốc gia đã tồn tại",
            'code.required' => "Hãy nhập vào ký hiệu",
            'code.unique' => "Ký hiệu đã tồn tại",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('countries')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Country::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên quốc gia đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'code' => [
                    'required',
                    Rule::unique('countries')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Country::onlyTrashed()
                            ->where('code', 'like', '%' . $request->code . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->code) {
                                return $fail('Ký hiệu đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('country.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('country.index'), 'message' => 'Sửa quốc gia thành công']);
    }

    public function backUp()
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.country.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $category = Country::onlyTrashed()->select('countries.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('country.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('country.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('code', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $country = Country::withTrashed()->find($id);
        if (empty($country)) {
            return response()->json(['success' => 'Quốc gia không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại quốc gia']);
        }

        $country->delete();
        return response()->json(['success' => 'Xóa quốc gia thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $country = Country::withTrashed()->find($id);
        if (empty($country)) {
            return response()->json(['success' => 'Quốc gia không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại quốc gia']);
        }

        $country->restore();
        return response()->json(['success' => 'Khôi phục quốc gia thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $country = Country::withTrashed()->find($id);
        if (empty($country)) {
            return response()->json(['success' => 'Quốc gia không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại quốc gia']);
        }

        $country->forceDelete();
        return response()->json(['success' => 'Xóa quốc gia thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $country = Country::withTrashed()->whereIn('id', $idAll);

        if ($country->count() == 0) {
            return response()->json(['success' => 'Xóa quốc gia thất bại !']);
        }

        $country->delete();
        return response()->json(['success' => 'Xóa quốc gia thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $country = Country::withTrashed()->whereIn('id', $idAll);

        if ($country->count() == 0) {
            return response()->json(['success' => 'Khôi phục quốc gia thất bại !']);
        }

        $country->restore();
        return response()->json(['success' => 'Khôi phục quốc gia thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $country = Country::withTrashed()->whereIn('id', $idAll);

        if ($country->count() == 0) {
            return response()->json(['success' => 'Xóa quốc gia thất bại !']);
        }

        $country->forceDelete();
        return response()->json(['success' => 'Xóa quốc gia thành công !']);
    }
}