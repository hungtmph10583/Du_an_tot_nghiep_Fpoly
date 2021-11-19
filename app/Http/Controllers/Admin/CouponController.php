<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Coupons;
use App\Models\CouponType;
use App\Models\DiscountType;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.coupon.index');
    }

    public function getData(Request $request)
    {
        $breed = Coupons::select('coupons.*')->with('couponType', 'discountType');
        return dataTables::of($breed)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
            ->orderColumn('type', function ($row, $order) {
                return $row->orderBy('type', $order);
            })
            ->addColumn('type', function ($row) {
                return $row->couponType->name;
            })
            ->orderColumn('discount_type', function ($row, $order) {
                return $row->orderBy('discount_type', $order);
            })
            ->addColumn('discount_type', function ($row) {
                return $row->discountType->name;
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
                <a href="' . route('coupon.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                <a  class="btn btn-success" href="' . route('coupon.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                                    </span>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '3') {
                    $instance->where('status', $request->get('status'));
                }

                if ($request->get('cate') != '') {
                    $instance->where('category_id', $request->get('cate'));
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function addForm()
    {
        $coupon = Coupons::all();
        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        $product = Product::all();
        $category = Category::all();
        return view('admin.coupon.add-form', compact('coupon', 'couponType', 'discountType', 'product', 'category'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $model = new Coupons();

        if (!$model) {
            return redirect()->back();
        }

        if ($request->code) {
            $dupicate = Coupons::onlyTrashed()
                ->where('code', 'like', $request->code)->first();
        } else {
            $dupicate = null;
        }

        $message = [
            'code.required' => "Hãy nhập vào mã khuyến mãi",
            'code.unique' => "Mã khuyến mãi đã tồn tại",
            'type.required' => "Hãy chọn loại giảm giá",
            'product_id.required_without' => "Hãy chọn sản phẩm hoặc danh mục giảm giá",
            'category_id.required_without' => "Hãy chọn danh mục hoặc sản phẩm giảm giá",
            'discount.required' => 'Hãy nhập vào giá trị giảm giá',
            'discount.numeric' => 'Giá trị giảm giá phải là số',
            'start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.after' => 'Ngày kết thúc giảm phải sau ngày bắt đầu',
            'discount_type.required' => 'Hãy chọn kiểu giảm giá',
            'details.required' => 'Hãy nhập vào chi tiết giảm giá',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    Rule::unique('coupons')->ignore($id)
                ],
                'product_id' => 'required_without:category_id',
                'category_id' => 'required_without:product_id',
                'discount' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                //nullable cho phép validate không bắt buộc trừ khi có dữ liệu nhập vào
                'start_date' => 'nullable|date_format:Y-m-d H:i',
                'end_date' => 'nullable|date_format:Y-m-d H:i|after:start_date',
                'discount_type' => 'required',
                'details' => 'required',
                'type' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('coupon.index'), 'dupicate' => $dupicate]);
        } else {
            $model->fill($request->all());
            $model->user_id = Auth::id();
            $model->start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i');
            $model->end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i');
            $model->save();
            if ($request->has('product_id')) {
                foreach ($request->product_id as $i => $item) {
                    $product = Product::find($item);
                    $product->coupon_id = $model->id;
                    $product->save();
                }
            }

            if ($request->has('category_id')) {
                foreach ($request->category_id as $i => $item) {
                    $category = Category::find($item);
                    $category->coupon_id = $model->id;
                    $category->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('coupon.index'), 'message' => 'Thêm giảm giá thành công']);
    }
    public function editForm($id)
    {
        $coupon = Coupons::find($id);
        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        $product = Product::all();
        $category = Category::all();
        if (!$coupon) {
            return redirect()->back();
        }
        return view('admin.coupon.edit-form', compact('coupon', 'couponType', 'discountType', 'product', 'category'));
    }
    public function saveEdit($id, Request $request)
    {
        $model = Coupons::find($id);

        if (!$model) {
            return redirect()->back();
        }

        if ($request->code) {
            $dupicate = Coupons::onlyTrashed()
                ->where('code', 'like', $request->code)->first();
        } else {
            $dupicate = null;
        }

        $message = [
            'code.required' => "Hãy nhập vào mã khuyến mãi",
            'code.unique' => "Mã khuyến mãi đã tồn tại",
            'type.required' => "Hãy chọn loại giảm giá",
            'product_id.required_without' => "Hãy chọn sản phẩm hoặc danh mục giảm giá",
            'category_id.required_without' => "Hãy chọn danh mục hoặc sản phẩm giảm giá",
            'discount.required' => 'Hãy nhập vào giá trị giảm giá',
            'discount.numeric' => 'Giá trị giảm giá phải là số',
            'start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.after' => 'Ngày kết thúc giảm phải sau ngày bắt đầu',
            'discount_type.required' => 'Hãy chọn kiểu giảm giá',
            'details.required' => 'Hãy nhập vào chi tiết giảm giá',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    Rule::unique('coupons')->ignore($id)
                ],
                'product_id' => 'required_without:category_id',
                'category_id' => 'required_without:product_id',
                'discount' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                //nullable cho phép validate không bắt buộc trừ khi có dữ liệu nhập vào
                'start_date' => 'nullable|date_format:Y-m-d H:i',
                'end_date' => 'nullable|date_format:Y-m-d H:i|after:start_date',
                'discount_type' => 'required',
                'details' => 'required',
                'type' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('coupon.index'), 'dupicate' => $dupicate]);
        } else {
            $model->fill($request->all());
            $model->user_id = Auth::id();
            $model->start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i');
            $model->end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i');
            $model->save();
            if ($request->has('product_id')) {
                foreach ($request->product_id as $i => $item) {
                    $product = Product::find($item);
                    $product->coupon_id = $model->id;
                    $product->save();
                }
            }

            if ($request->has('category_id')) {
                foreach ($request->category_id as $i => $item) {
                    $category = Category::find($item);
                    $category->coupon_id = $model->id;
                    $category->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('coupon.index'), 'message' => 'Sửa giảm giá thành công']);
    }
    public function detail(Request $request)
    {
    }
    public function remove(Request $request)
    {
    }
}