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
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.coupon.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $coupon = Coupons::select('coupons.*')->with('couponType', 'discountType');
        return dataTables::of($coupon)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('type', function ($row, $order) {
                return $row->orderBy('type', $order);
            })
            ->addColumn('type', function ($row) {
                return $row->couponType->name;
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
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('coupon.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
            ->rawColumns(['status', 'action', 'checkbox'])
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

        $message = [
            'code.required' => "Hãy nhập vào mã khuyến mãi",
            'code.unique' => "Mã khuyến mãi đã tồn tại",
            'code.regex' => "Mã khuyến mãi không chứa kí tự đặc biệt và số",
            'code.min' => "Mã khuyến mãi ít nhất 3 kí tự",
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
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('coupons')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Coupons::onlyTrashed()
                            ->where('code', 'like', '%' . $request->code . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->code) {
                                return $fail('Mã khuyến mãi đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
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
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('coupon.index')]);
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

        $message = [
            'code.required' => "Hãy nhập vào mã khuyến mãi",
            'code.unique' => "Mã khuyến mãi đã tồn tại",
            'code.regex' => "Mã khuyến mãi không chứa kí tự đặc biệt và số",
            'code.min' => "Mã khuyến mãi ít nhất 3 kí tự",
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
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('coupons')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Coupons::onlyTrashed()
                            ->where('code', 'like', '%' . $request->code . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->code) {
                                return $fail('Mã khuyến mãi đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
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
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('coupon.index')]);
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

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.coupon.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $coupon = Coupons::onlyTrashed()->select('coupons.*')->with('category');
        return dataTables::of($coupon)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('type', function ($row, $order) {
                return $row->orderBy('type', $order);
            })
            ->addColumn('type', function ($row) {
                return $row->couponType->name;
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
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('coupon.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('coupon.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $coupon = Coupons::withTrashed()->find($id);
        $coupon->with(['couponType', 'discountType', 'products', 'couponUsage', 'accessory', 'category']);
        if (empty($coupon)) {
            return response()->json(['success' => 'Giảm không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giảm giá']);
        }
        if ($coupon->category()->count() !== 0) {
            $coupon->category()->each(function ($product) {

                if ($product->breeds()->count() == 0) {
                    $product->products()->each(function ($related) {
                        $related->galleries()->delete();
                        $related->orderDetails()->delete();
                        $related->carts()->delete();
                        $related->reviews()->delete();
                    });
                    $product->products()->delete();
                } else {

                    $product->breeds()->each(function ($related) {
                        $related->products()->each(function ($related) {
                            $related->galleries()->delete();
                            $related->orderDetails()->delete();
                            $related->carts()->delete();
                            $related->reviews()->delete();
                        });
                        $related->products()->delete();
                    });
                    $product->breeds()->delete();
                    $product->products()->each(function ($related) {
                        $related->galleries()->delete();
                        $related->orderDetails()->delete();
                        $related->carts()->delete();
                        $related->reviews()->delete();
                    });
                    $product->products()->delete();
                }

                $product->accessory()->each(function ($related) {
                    $related->galleries()->delete();
                });

                $product->accessory()->delete();
            });

            $coupon->category()->delete();
        }

        $coupon->products()->each(function ($related) {
            $related->galleries()->delete();
            $related->orderDetails()->delete();
            $related->carts()->delete();
            $related->reviews()->delete();
        });

        $coupon->accessory()->each(function ($related) {
            $related->galleries()->delete();
        });
        $coupon->accessory()->delete();
        $coupon->products()->delete();
        $coupon->couponUsage()->delete();
        $coupon->delete();
        return response()->json(['success' => 'Xóa giảm giá thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $coupon = Coupons::withTrashed()->find($id);
        if (empty($coupon)) {
            return response()->json(['success' => 'Giảm giá không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        if ($coupon->category()->count() !== 0) {

            $coupon->category()->each(function ($product) {

                if ($product->breeds()->count() == 0) {
                    $product->products()->each(function ($related) {
                        $related->galleries()->restore();
                        $related->orderDetails()->restore();
                        $related->carts()->restore();
                        $related->reviews()->restore();
                        $related->category()->restore();
                    });
                    $product->products()->restore();
                } else {

                    $product->breeds()->each(function ($related) {
                        $related->products()->each(function ($related) {
                            $related->galleries()->restore();
                            $related->orderDetails()->restore();
                            $related->carts()->restore();
                            $related->reviews()->restore();
                            $related->category()->restore();
                        });
                        $related->products()->restore();
                    });
                    $product->breeds()->restore();
                    $product->products()->each(function ($related) {
                        $related->galleries()->restore();
                        $related->orderDetails()->restore();
                        $related->carts()->restore();
                        $related->reviews()->restore();
                        $related->category()->restore();
                    });
                    $product->products()->restore();
                }

                $product->accessory()->each(function ($related) {
                    $related->galleries()->restore();
                    $related->category()->restore();
                });

                $product->accessory()->restore();
            });

            $coupon->category()->restore();
        }

        $coupon->products()->each(function ($related) {
            $related->galleries()->restore();
            $related->orderDetails()->restore();
            $related->carts()->restore();
            $related->reviews()->restore();
            $related->category()->restore();
        });

        $coupon->accessory()->each(function ($related) {
            $related->galleries()->restore();
            $related->category()->restore();
        });
        $coupon->accessory()->restore();
        $coupon->products()->restore();
        $coupon->couponUsage()->restore();
        $coupon->restore();
        return response()->json(['success' => 'Khôi phục giảm giá thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $coupon = Coupons::withTrashed()->find($id);
        if (empty($coupon)) {
            return response()->json(['success' => 'Giảm giá không tồn tại !', 'undo' => "Xóa thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        if ($coupon->category()->count() !== 0) {

            $coupon->category()->each(function ($product) {

                if ($product->breeds()->count() == 0) {
                    $product->products()->each(function ($related) {
                        $related->galleries()->forceDelete();
                        $related->orderDetails()->forceDelete();
                        $related->carts()->forceDelete();
                        $related->reviews()->forceDelete();
                    });
                    $product->products()->forceDelete();
                } else {

                    $product->breeds()->each(function ($related) {
                        $related->products()->each(function ($related) {
                            $related->galleries()->forceDelete();
                            $related->orderDetails()->forceDelete();
                            $related->carts()->forceDelete();
                            $related->reviews()->forceDelete();
                        });
                        $related->products()->forceDelete();
                    });
                    $product->breeds()->forceDelete();
                    $product->products()->each(function ($related) {
                        $related->galleries()->forceDelete();
                        $related->orderDetails()->forceDelete();
                        $related->carts()->forceDelete();
                        $related->reviews()->forceDelete();
                    });
                    $product->products()->forceDelete();
                }

                $product->accessory()->each(function ($related) {
                    $related->galleries()->forceDelete();
                });

                $product->accessory()->forceDelete();
            });

            $coupon->category()->forceDelete();
        }

        $coupon->products()->each(function ($related) {
            $related->galleries()->forceDelete();
            $related->orderDetails()->forceDelete();
            $related->carts()->forceDelete();
            $related->reviews()->forceDelete();
        });

        $coupon->accessory()->each(function ($related) {
            $related->galleries()->forceDelete();
        });
        $coupon->accessory()->forceDelete();
        $coupon->products()->forceDelete();
        $coupon->couponUsage()->forceDelete();
        $coupon->forceDelete();
        return response()->json(['success' => 'Xóa giảm giá thành công !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $coupon = Coupons::withTrashed()->whereIn('id', $idAll);

        if ($coupon->count() == 0) {
            return response()->json(['success' => 'Xóa giống loài thất bại !']);
        }
        $coupon->each(function ($couponMul) {
            if ($couponMul->category()->count() !== 0) {

                $couponMul->category()->each(function ($product) {

                    if ($product->breeds()->count() == 0) {
                        $product->products()->each(function ($related) {
                            $related->galleries()->delete();
                            $related->orderDetails()->delete();
                            $related->carts()->delete();
                            $related->reviews()->delete();
                        });
                        $product->products()->delete();
                    } else {

                        $product->breeds()->each(function ($related) {
                            $related->products()->each(function ($related) {
                                $related->galleries()->delete();
                                $related->orderDetails()->delete();
                                $related->carts()->delete();
                                $related->reviews()->delete();
                            });
                            $related->products()->delete();
                        });
                        $product->breeds()->delete();
                        $product->products()->each(function ($related) {
                            $related->galleries()->delete();
                            $related->orderDetails()->delete();
                            $related->carts()->delete();
                            $related->reviews()->delete();
                        });
                        $product->products()->delete();
                    }

                    $product->accessory()->each(function ($related) {
                        $related->galleries()->delete();
                    });

                    $product->accessory()->delete();
                });

                $couponMul->category()->delete();
            }
            $couponMul->products()->each(function ($related) {
                $related->galleries()->delete();
                $related->orderDetails()->delete();
                $related->carts()->delete();
                $related->reviews()->delete();
            });

            $couponMul->accessory()->each(function ($related) {
                $related->galleries()->delete();
            });
            $couponMul->accessory()->delete();
            $couponMul->products()->delete();
            $couponMul->couponUsage()->delete();
        });
        $coupon->delete();

        return response()->json(['success' => 'Xóa giảm giá thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $coupon = Coupons::withTrashed()->whereIn('id', $idAll);

        if ($coupon->count() == 0) {
            return response()->json(['success' => 'Khôi phục giảm giá thất bại !']);
        }
        $coupon->each(function ($couponMul) {
            if ($couponMul->category()->count() !== 0) {

                $couponMul->category()->each(function ($product) {

                    if ($product->breeds()->count() == 0) {
                        $product->products()->each(function ($related) {
                            $related->galleries()->restore();
                            $related->orderDetails()->restore();
                            $related->carts()->restore();
                            $related->reviews()->restore();
                            $related->category()->restore();
                        });
                        $product->products()->restore();
                    } else {

                        $product->breeds()->each(function ($related) {
                            $related->products()->each(function ($related) {
                                $related->galleries()->restore();
                                $related->orderDetails()->restore();
                                $related->carts()->restore();
                                $related->reviews()->restore();
                                $related->category()->restore();
                            });
                            $related->products()->restore();
                        });
                        $product->breeds()->restore();
                        $product->products()->each(function ($related) {
                            $related->galleries()->restore();
                            $related->orderDetails()->restore();
                            $related->carts()->restore();
                            $related->reviews()->restore();
                            $related->category()->restore();
                        });
                        $product->products()->restore();
                    }

                    $product->accessory()->each(function ($related) {
                        $related->galleries()->restore();
                        $related->category()->restore();
                    });

                    $product->accessory()->restore();
                });

                $couponMul->category()->restore();
            }
            $couponMul->products()->each(function ($related) {
                $related->galleries()->restore();
                $related->orderDetails()->restore();
                $related->carts()->restore();
                $related->reviews()->restore();
                $related->category()->restore();
            });

            $couponMul->accessory()->each(function ($related) {
                $related->galleries()->restore();
                $related->category()->restore();
            });
            $couponMul->accessory()->restore();
            $couponMul->products()->restore();
            $couponMul->couponUsage()->restore();
        });
        $coupon->restore();

        return response()->json(['success' => 'Khôi phục giảm giá thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $coupon = Coupons::withTrashed()->whereIn('id', $idAll);

        if ($coupon->count() == 0) {
            return response()->json(['success' => 'Xóa giảm giá thất bại !']);
        }
        $coupon->each(function ($couponMul) {
            if ($couponMul->category()->count() !== 0) {

                $couponMul->category()->each(function ($product) {

                    if ($product->breeds()->count() == 0) {
                        $product->products()->each(function ($related) {
                            $related->galleries()->forceDelete();
                            $related->orderDetails()->forceDelete();
                            $related->carts()->forceDelete();
                            $related->reviews()->forceDelete();
                        });
                        $product->products()->forceDelete();
                    } else {

                        $product->breeds()->each(function ($related) {
                            $related->products()->each(function ($related) {
                                $related->galleries()->forceDelete();
                                $related->orderDetails()->forceDelete();
                                $related->carts()->forceDelete();
                                $related->reviews()->forceDelete();
                            });
                            $related->products()->forceDelete();
                        });
                        $product->breeds()->forceDelete();
                        $product->products()->each(function ($related) {
                            $related->galleries()->forceDelete();
                            $related->orderDetails()->forceDelete();
                            $related->carts()->forceDelete();
                            $related->reviews()->forceDelete();
                        });
                        $product->products()->forceDelete();
                    }

                    $product->accessory()->each(function ($related) {
                        $related->galleries()->forceDelete();
                    });

                    $product->accessory()->forceDelete();
                });

                $couponMul->category()->forceDelete();
            }
            $couponMul->products()->each(function ($related) {
                $related->galleries()->forceDelete();
                $related->orderDetails()->forceDelete();
                $related->carts()->forceDelete();
                $related->reviews()->forceDelete();
            });

            $couponMul->accessory()->each(function ($related) {
                $related->galleries()->forceDelete();
            });
            $couponMul->accessory()->forceDelete();
            $couponMul->products()->forceDelete();
            $couponMul->couponUsage()->forceDelete();
        });
        $coupon->forceDelete();

        return response()->json(['success' => 'Xóa giảm giá thành công !']);
    }
}