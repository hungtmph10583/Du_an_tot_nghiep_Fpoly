<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ModelHasRole;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('admin.user.index', [
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }

    public function getData(Request $request)
    {
        $user = User::select('users.*');
        return dataTables::of($user)
            //thêm id vào tr trong datatable
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
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
                    <a href="' . route('user.profile', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a href="' . route('user.edit', ['id' => $row->id]) . '" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                    <a class="btn btn-outline-danger" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '3') {
                    $instance->where('status', $request->get('status'));
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function addForm()
    {
        $role = Role::all();
        return view('admin.user.add-form', [
            'roles' => $role
        ]);
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'name.required' => "Hãy nhập vào tên người dùng",
            'name.unique' => "Tên người dùng đã tồn tại",
            'name.regex' => "Tên người dùng không chứa kí tự đặc biệt và số",
            'name.min' => "Tên người dùng ít nhất 3 kí tự",
            'status.required' => "Hãy chọn trạng thái người dùng",
            'image.required' => 'Hãy chọn ảnh người dùng',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
            'email.required' => 'Hãy nhập tài khoản Email',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Hãy nhập số điện thoại',
            'phone.min' => 'Số điện thoại có độ dài nhỏ nhất là 10 ký tự',
            'phone.max' => 'Số điện thoại có độ dài lớn nhất là 11 ký tự',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'password.required' => 'Hãy nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu nhiều nhất 20 ký tự',
            'cfpassword.required' => 'Hãy nhập lại mật khẩu',
            'cfpassword.same' => 'Mật khẩu nhập lại không chính xác',
            'role_id.required' => 'Chọn quyền cho người dùng'
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = User::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên người dùng đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'status' => 'required',
                'image' => 'required|mimes:jpg,bmp,png,jpeg|max:2048',
                'email' => 'required|email',
                'phone' => [
                    'required',
                    'min:10',
                    'max:11',
                    'regex:/^(09|03|07|08|05)[0-9]{8,9}$/'
                ],
                'password' => 'required|min:6|max:20',
                'cfpassword' => 'required|same:password',
                'role_id' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {
            $model = new User();

            $model->fill($request->all());

            // upload ảnh
            if ($request->hasFile('image')) {
                $model->avatar = $request->file('image')->storeAs('uploads/users', uniqid() . '-' . $request->image->getClientOriginalName());
            }

            /**
             * HungTM
             * Tao token
             * Start
             */
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet .= "0123456789";
            $max = strlen($codeAlphabet);

            for ($i = 0; $i <= 10; $i++) {
                $token .= $codeAlphabet[rand(0, $max - 1)];
            }
            /**
             * HungTM
             * Tao token
             * End
             */

            $model->password = Hash::make($request->password);
            $model->remember_token = $token;
            $model->save();

            // save quyen 
            if ($request->has('role_id')) {
                $model->assignRole($request->role_id);
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/tai-khoan')]);
    }

    public function editForm($id)
    {
        $model = User::find($id);
        $model->load('model_has_role');

        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('admin.user.edit-form', [
            'model' => $model,
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }

    public function saveEdit($id, Request $request)
    {
        $model = User::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào tên người dùng",
            'name.unique' => "Tên người dùng đã tồn tại",
            'name.regex' => "Tên người dùng không chứa kí tự đặc biệt và số",
            'name.min' => "Tên người dùng ít nhất 3 kí tự",
            'status.required' => "Hãy chọn trạng thái người dùng",
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
            'email.required' => 'Hãy nhập tài khoản Email',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Hãy nhập số điện thoại',
            'phone.min' => 'Số điện thoại có độ dài nhỏ nhất là 10 ký tự',
            'phone.max' => 'Số điện thoại có độ dài lớn nhất là 11 ký tự',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'role_id' => 'Chọn quyền cho người dùng'
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = User::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên người dùng đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'status' => 'required',
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'email' => 'email',
                'phone' => [
                    'required',
                    'min:10',
                    'max:11',
                    'regex:/^(09|03|07|08|05)[0-9]{8,9}$/'
                ],
                'role_id' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()]);
        } else {

            $model->fill($request->all());
            // upload ảnh
            if ($request->hasFile('image')) {
                $model->avatar = $request->file('image')->storeAs('uploads/users', uniqid() . '-' . $request->image->getClientOriginalName());
            }
            $model->save();

            if ($request->has('role_id')) {
                DB::table('model_has_roles')->where('model_id', $id)->delete();
                $model->assignRole($request->role_id);
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => asset('admin/tai-khoan')]);
    }

    public function proFile($id)
    {
        $user = User::find($id);
        $user->load('model_has_role');

        $mdh_role = ModelHasRole::all();
        $role = Role::all();
        return view('admin.user.pro-file', [
            'user' => $user,
            'mdh_role' => $mdh_role,
            'role' => $role
        ]);
    }

    public function remove($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['success' => 'Người dùng không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giảm giá']);
        }
        $product = $user->products();
        $product->each(function ($pro) {
            $pro->galleries()->delete();
            $pro->orderDetails()->delete();
            $pro->carts()->delete();
            $pro->reviews()->delete();
        });
        $product->delete();
        $user->reviews()->delete();
        $user->slides()->delete();
        $user->orders()->delete();
        $coupon = $user->coupons();
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
        $user->carts()->delete();
        $user->breeds()->delete();
        $user->blogs()->delete();
        $user->announcements()->delete();
        $accessories = $user->accessories();
        $accessories->each(function ($accessory) {
            $accessory->galleries()->delete();
        });
        $accessories->delete();
        $user->delete();
        return response()->json(['success' => 'Xóa thú cưng thành công !', 'datas' => 1]);
    }

    public function restore($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['success' => 'Người dùng không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giảm giá']);
        }
        $product = $user->products();
        $product->each(function ($pro) {
            $pro->galleries()->restore();
            $pro->orderDetails()->restore();
            $pro->carts()->restore();
            $pro->reviews()->restore();
            $related->category()->restore();
        });
        $product->restore();
        $user->reviews()->restore();
        $user->slides()->restore();
        $user->orders()->restore();
        $coupon = $user->coupons();
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
        $user->carts()->restore();
        $user->breeds()->restore();
        $user->blogs()->restore();
        $user->announcements()->restore();
        $accessories = $user->accessories();
        $accessories->each(function ($related) {
            $related->galleries()->restore();
            $related->category()->restore();
        });
        $accessories->restore();
        $user->restore();

        return response()->json(['success' => 'Khôi người dùng thành công !']);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['success' => 'Người dùng không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giảm giá']);
        }
        $product = $user->products();
        $product->each(function ($pro) {
            $pro->galleries()->forceDelete();
            $pro->orderDetails()->forceDelete();
            $pro->carts()->forceDelete();
            $pro->reviews()->forceDelete();
        });
        $product->forceDelete();
        $user->reviews()->forceDelete();
        $user->slides()->forceDelete();
        $user->orders()->forceDelete();
        $coupon = $user->coupons();
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
        $user->carts()->forceDelete();
        $user->breeds()->forceDelete();
        $user->blogs()->forceDelete();
        $user->announcements()->forceDelete();
        $accessories = $user->accessories();
        $accessories->each(function ($accessory) {
            $accessory->galleries()->forceDelete();
        });
        $accessories->forceDelete();
        $user->forceDelete();

        return response()->json(['success' => 'Xóa người dùng thành công !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $user = User::withTrashed()->whereIn('id', $idAll);

        if ($user->count() == 0) {
            return response()->json(['success' => 'Xóa người dùng thất bại !']);
        }

        $user->each(function ($user) {
            $user->products()->each(function ($pro) {
                $pro->galleries()->delete();
                $pro->orderDetails()->delete();
                $pro->carts()->delete();
                $pro->reviews()->delete();
            });
            $user->products()->delete();
            $user->reviews()->delete();
            $user->slides()->delete();
            $user->orders()->delete();
            $user->coupons()->each(function ($couponMul) {
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
            $user->coupons()->delete();
            $user->carts()->delete();
            $user->breeds()->delete();
            $user->blogs()->delete();
            $user->announcements()->delete();
            $accessories = $user->accessories();
            $accessories->each(function ($accessory) {
                $accessory->galleries()->delete();
            });
            $accessories->delete();
        });
        $user->delete();

        return response()->json(['success' => 'Xóa người dùng thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $user = User::withTrashed()->whereIn('id', $idAll);

        if ($user->count() == 0) {
            return response()->json(['success' => 'Xóa người dùng thất bại !']);
        }

        $user->each(function ($user) {
            $user->products()->each(function ($pro) {
                $pro->galleries()->restore();
                $pro->orderDetails()->restore();
                $pro->carts()->restore();
                $pro->reviews()->restore();
                $pro->category()->restore();
            });
            $user->products()->restore();
            $user->reviews()->restore();
            $user->slides()->restore();
            $user->orders()->restore();
            $user->coupons()->each(function ($couponMul) {
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
            $user->coupons()->restore();
            $user->carts()->restore();
            $user->breeds()->restore();
            $user->blogs()->restore();
            $user->announcements()->restore();
            $accessories = $user->accessories();
            $accessories->each(function ($accessory) {
                $accessory->galleries()->restore();
                $accessory->category()->restore();
            });
            $accessories->restore();
        });
        $user->restore();

        return response()->json(['success' => 'Khôi phục người dùng thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $user = User::withTrashed()->whereIn('id', $idAll);

        if ($user->count() == 0) {
            return response()->json(['success' => 'Xóa người dùng thất bại !']);
        }

        $user->each(function ($user) {
            $user->products()->each(function ($pro) {
                $pro->galleries()->delete();
                $pro->orderDetails()->delete();
                $pro->carts()->delete();
                $pro->reviews()->delete();
            });
            $user->products()->delete();
            $user->reviews()->delete();
            $user->slides()->delete();
            $user->orders()->delete();
            $user->coupons()->each(function ($couponMul) {
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
            $user->coupons()->delete();
            $user->carts()->delete();
            $user->breeds()->delete();
            $user->blogs()->delete();
            $user->announcements()->delete();
            $accessories = $user->accessories();
            $accessories->each(function ($accessory) {
                $accessory->galleries()->delete();
            });
            $accessories->delete();
        });
        $user->delete();

        return response()->json(['success' => 'Xóa người dùng thành công !']);
    }
}