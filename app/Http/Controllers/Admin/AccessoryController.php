<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\AccessoryGallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class AccessoryController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.accessory.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $accessory = Accessory::select('accessories.*')->with('category');
        return dataTables::of($accessory)
            //thêm id vào tr trong datatable
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_id', function ($row, $order) {
                return $row->orderBy('category_id', $order);
            })
            ->orderColumn('status', function ($row, $order) {
                return $row->orderBy('status', $order);
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-primary">Active</span>';
                } elseif ($row->status == 0) {
                    return '<span class="badge badge-danger">Deactive</span>';
                } else {
                    return '<span class="badge badge-danger">Sắp ra mắt</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('accessory.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a  class="btn btn-success" href="' . route('accessory.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('accessory.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('description', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        $category = Category::all();
        $discountType = DiscountType::all();
        return view('admin.accessory.add-form', compact('category', 'discountType'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $model = new Accessory();
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào tên phụ kiện",
            'name.unique' => "Tên phụ kiện đã tồn tại",
            'name.regex' => "Tên phụ kiện không chứa kí tự đặc biệt và số",
            'name.min' => "Tên phụ kiện ít nhất 3 kí tự",
            'discount.unique' => "Giảm giá đã tồn tại",
            'discount.regex' => "Giảm giá không chứa kí tự đặc biệt và số",
            'discount.min' => "Giảm giá bé nhất là 1",
            'category_id.required' => "Hãy chọn phụ kiện",
            'price.required' => "Hãy nhập giá phụ kiện",
            'price.numeric' => "Giá phụ kiện phải là số",
            'status.required' => "Hãy chọn trạng thái phụ kiện",
            'quantity.required' => "Hãy nhập số lượng phụ kiện",
            'quantity.numeric' => "Số lượng phụ kiện phải là số",
            'discount_start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'discount_end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'galleries.*.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'galleries.*.max' => 'File ảnh không được quá 2MB',
            'image.required' => 'Hãy chọn ảnh phụ kiện',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    'min:3',
                    Rule::unique('accessories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Accessory::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Phụ kiện đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'discount' => [
                    'nullable',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                'discount_start_date' => 'nullable|date_format:Y-m-d H:i',
                'discount_end_date' => 'nullable|date_format:Y-m-d H:i|after:discount_start_date',
                'category_id' => 'required',
                'price' => 'required|numeric',
                'status' => 'required',
                'quantity' => 'required|numeric',
                'galleries.*' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'image' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'success' => 'success', 'error' => $validator->errors(), 'url' => route('accessory.index')]);
        } else {
            $model->fill($request->all());

            if ($request->has('discount') && $request->missing('discount')) {
                if ($request->discount > 100) {
                    $model->discount_type = 1;
                } else {
                    $model->discount_type = 2;
                }
            }

            if ($request->hasFile('image')) {
                $model->image = $request->file('image')->storeAs('uploads/accessories', uniqid() . '-' . $request->image->getClientOriginalName());
            }

            $model->user_id = Auth::id();
            $model->save();

            if ($request->has('galleries')) {
                foreach ($request->galleries as $i => $item) {
                    $galleryObj = new AccessoryGallery();
                    $galleryObj->accessory_id = $model->id;
                    $galleryObj->order_no = $i + 1;
                    $galleryObj->image_url = $item->storeAs(
                        'uploads/accessories/galleries/' . $model->id,
                        uniqid() . '-' . $item->getClientOriginalName()
                    );
                    $galleryObj->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('accessory.index'), 'message' => 'Thêm phụ kiện thành công']);
    }

    public function editForm($id)
    {
        $model = Accessory::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $category = Category::all();
        $discountType = DiscountType::all();
        $model->load('galleries', 'category');
        return view('admin.accessory.edit-form', compact('model', 'category', 'discountType'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = Accessory::find($id);

        if (!$model) {
            return redirect()->back();
        }
        $message = [
            'name.required' => "Hãy nhập vào tên phụ kiện",
            'name.unique' => "Tên phụ kiện đã tồn tại",
            'name.regex' => "Tên phụ kiện không chứa kí tự đặc biệt và số",
            'name.min' => "Tên phụ kiện ít nhất 3 kí tự",
            'discount.unique' => "Giảm giá đã tồn tại",
            'discount.regex' => "Giảm giá không chứa kí tự đặc biệt và số",
            'discount.min' => "Giảm giá bé nhất là 1",
            'category_id.required' => "Hãy chọn phụ kiện",
            'price.required' => "Hãy nhập giá phụ kiện",
            'price.numeric' => "Giá phụ kiện phải là số",
            'status.required' => "Hãy chọn trạng thái phụ kiện",
            'quantity.required' => "Hãy nhập số lượng phụ kiện",
            'quantity.numeric' => "Số lượng phụ kiện phải là số",
            'discount_start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'discount_end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'galleries.*.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'galleries.*.max' => 'File ảnh không được quá 2MB',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    'min:3',
                    Rule::unique('accessories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Accessory::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Phụ kiện đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'discount' => [
                    'nullable',
                    'numeric',
                    'min:1',
                    Rule::unique('accessories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                'discount_start_date' => 'nullable|date_format:Y-m-d H:i',
                'discount_end_date' => 'nullable|date_format:Y-m-d H:i|after:discount_start_date',
                'category_id' => 'required',
                'price' => 'required|numeric',
                'status' => 'required',
                'quantity' => 'required|numeric',
                'galleries.*' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());

            if ($request->has('discount') && $request->missing('discount')) {
                if ($request->discount > 100) {
                    $model->discount_type = 1;
                } else {
                    $model->discount_type = 2;
                }
            }

            if ($request->hasFile('image')) {
                Storage::delete($model->image);
                $model->image = $request->file('image')->storeAs('uploads/accessories', uniqid() . '-' . $request->image->getClientOriginalName());
            }

            $model->user_id = Auth::id();
            $model->save();
            /* gallery
         * xóa gallery đc mark là bị xóa đi
        */
            if ($request->has('removeGalleryIds')) {
                $strIds = rtrim($request->removeGalleryIds, '|');
                $lstIds = explode('|', $strIds);
                // xóa các ảnh vật lý
                $removeList = AccessoryGallery::whereIn('id', $lstIds)->get();
                foreach ($removeList as $gl) {
                    Storage::delete($gl->url);
                }
                AccessoryGallery::destroy($lstIds);
            }

            // lưu mới danh sách gallery
            if ($request->has('galleries')) {
                foreach ($request->galleries as $i => $item) {
                    $galleryObj = new AccessoryGallery();
                    $galleryObj->accessory_id = $model->id;
                    $galleryObj->order_no = $i + 1;
                    $galleryObj->url = $item->storeAs(
                        'uploads/accessories/galleries/' . $model->id,
                        uniqid() . '-' . $item->getClientOriginalName()
                    );
                    $galleryObj->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/phu-kien')]);
    }

    public function detail($id)
    {
        $model = Accessory::find($id);
        $model->load('galleries', 'category');

        $category = Category::all();

        return view('admin.accessory.detail', compact('model', 'category'));
    }

    public function remove($id)
    {
        $accessory = Accessory::find($id);

        if ($accessory->count() == 0) {
            return response()->json(['success' => 'Xóa thú cưng thất bại !', 'undo' => "Hoàn tác thất bại !"]);
        }

        $accessory->galleries()->delete();
        // $accessory->orderDetails()->delete();
        // $accessory->carts()->delete();
        // $accessory->reviews()->delete();
        $accessory->delete();

        return response()->json(['success' => 'Xóa thú cưng thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $accessory = Accessory::withTrashed()->find($id);

        if ($accessory->count() == 0) {
            return response()->json(['success' => 'phụ kiện không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại phụ kiện']);
        }

        $accessory->galleries()->restore();
        $accessory->category()->restore();
        // $accessory->orderDetails()->restore();
        // $accessory->carts()->restore();
        // $accessory->reviews()->restore();
        $accessory->restore();

        return response()->json(['success' => 'Khôi phục thành công !']);
    }

    public function delete($id)
    {
        $accessory = Accessory::withTrashed()->find($id);

        if ($accessory->count() == 0) {
            return response()->json(['success' => 'phụ kiện không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại phụ kiện']);
        }

        $accessory->galleries()->forceDelete();
        // $accessory->orderDetails()->forceDelete();
        // $accessory->carts()->forceDelete();
        // $accessory->reviews()->forceDelete();
        $accessory->forceDelete();

        return response()->json(['success' => 'Xóa phụ kiện thành công !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $accessory = Accessory::withTrashed()->whereIn('id', $idAll);

        if ($accessory->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục thất bại !']);
        }

        $accessory->each(function ($related) {
            $related->galleries()->delete();
            // $related->orderDetails()->delete();
            // $related->carts()->delete();
            // $related->reviews()->delete();
        });
        $accessory->delete();

        return response()->json(['success' => 'Xóa phụ kiện thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $accessory = Accessory::withTrashed()->whereIn('id', $idAll);

        if ($accessory->count() == 0) {
            return response()->json(['success' => 'Xóa danh mục thất bại !']);
        }

        $accessory->each(function ($related) {
            $related->galleries()->restore();
            $related->category()->restore();
            // $related->orderDetails()->restore();
            // $related->carts()->restore();
            // $related->reviews()->restore();
        });
        $accessory->restore();

        return response()->json(['success' => 'Khôi phục phụ kiện thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $accessory = Accessory::withTrashed()->whereIn('id', $idAll);

        if ($accessory->count() == 0) {
            return response()->json(['success' => 'Xóa phụ kiện thất bại !']);
        }

        $accessory->each(function ($related) {
            $related->galleries()->forceDelete();
            // $related->orderDetails()->forceDelete();
            // $related->carts()->forceDelete();
            // $related->reviews()->forceDelete();
        });
        $accessory->forceDelete();

        return response()->json(['success' => 'Xóa phụ kiện thành công !']);
    }
}