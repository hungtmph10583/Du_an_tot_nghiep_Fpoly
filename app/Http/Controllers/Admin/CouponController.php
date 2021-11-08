<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.coupon.add-form', compact('coupon', 'couponType', 'discountType', 'product'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $model = new Coupons();
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'code.required' => "Hãy nhập vào mã khuyến mãi",
            'code.unique' => "Mã khuyến mãi đã tồn tại",
            'type.required' => "Hãy chọn loại giảm giá",
            'product_id.required' => "Hãy chọn sản phẩm giảm giá",
            'discount.required' => 'Hãy nhập vào giá trị giảm giá',
            'discount.numeric' => 'Giá trị giảm giá phải là số',
            'discount_type.required' => 'Hãy chọn kiểu giảm giá',
            'details.required' => 'Hãy nhập vào chi tiết giảm giá'
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    Rule::unique('coupons')->ignore($id)
                ],
                'product_id' => 'required',
                'discount' => 'required|numeric',
                'discount_type' => 'required',
                'details' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());
            $model->user_id = Auth::id();
            $model->save();
            if ($request->has('product_id')) {
                foreach ($request->product_id as $i => $item) {
                    $product = Product::find($item);
                    $product->discount = $request->discount;
                    $product->discount_type = $request->discount_type;
                    $product->discount_start_date = $request->start_date;
                    $product->discount_end_date = $request->end_date;
                    $product->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/giam-gia')]);
    }
    public function editForm($id)
    {
        $coupon = Coupons::find($id);
        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        $product = Product::all();
        if (!$coupon) {
            return redirect()->back();
        }
        return view('admin.coupon.edit-form', compact('coupon', 'couponType', 'discountType', 'product'));
    }
    public function saveEdit($id, Request $request)
    {
        $model = Coupons::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'code.required' => "Hãy nhập vào mã khuyến mãi",
            'code.unique' => "Mã khuyến mãi đã tồn tại",
            'type.required' => "Hãy chọn loại giảm giá",
            'product_id.required' => "Hãy chọn sản phẩm giảm giá",
            'discount.required' => 'Hãy nhập vào giá trị giảm giá',
            'discount.numeric' => 'Giá trị giảm giá phải là số',
            'discount_type.required' => 'Hãy chọn kiểu giảm giá',
            'details.required' => 'Hãy nhập vào chi tiết giảm giá'
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    Rule::unique('coupons')->ignore($id)
                ],
                'product_id' => 'required',
                'discount' => 'required|numeric',
                'discount_type' => 'required',
                'details' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model->fill($request->all());
            $model->user_id = Auth::id();
            $model->save();
            if ($request->has('product_id')) {
                foreach ($request->product_id as $i => $item) {
                    $product = Product::find($item);
                    $product->discount = $request->discount;
                    $product->discount_type = $request->discount_type;
                    $product->discount_start_date = $request->start_date;
                    $product->discount_end_date = $request->end_date;
                    $product->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/giam-gia')]);
    }
    public function detail(Request $request)
    {
    }
    public function remove(Request $request)
    {
    }
}