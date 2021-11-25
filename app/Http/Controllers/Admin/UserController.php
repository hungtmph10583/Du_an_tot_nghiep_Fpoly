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
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên người dùng đã tồn tại",
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
                    Rule::unique('users')->ignore($id)
                ],
                'status' => 'required',
                'image' => 'required|mimes:jpg,bmp,png,jpeg|max:2048',
                'email' => 'required|email',
                'phone' => 'required|min:10|max:11|regex:/(0)[0-9]{8,9}/',
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
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên người dùng đã tồn tại",
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
                    Rule::unique('users')->ignore($id)
                ],
                'status' => 'required',
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'email' => 'email',
                'phone' => 'min:10|max:11|regex:/(0)[0-9]{8,9}/',
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
        $product = $user->products();
        $product->each(function ($pro) {
            $pro->galleries()->delete();
            $pro->orderDetails()->delete();
        });
        $product->delete();
        $user->reviews()->delete();
        $user->slides()->delete();
        $user->orders()->delete();
        $coupon = $user->coupons();
        $coupon->each(function ($coup) {
            $coup->couponUsage()->delete();
            $coup->accessory()->each(function ($galleries) {
                $galleries->delete();
            });
            $coup->accessory()->delete();
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
}