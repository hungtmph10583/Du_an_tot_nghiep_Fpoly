<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.order.index');
    }

    public function getData(Request $request)
    {
        $order = Order::select('orders.*');
        return dataTables::of($order)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('order.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a  class="btn btn-success" href="' . route('order.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function editForm(Request $request)
    {
        return view('admin.order.edit-form');
    }
}