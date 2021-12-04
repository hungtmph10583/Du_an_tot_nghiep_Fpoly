<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class StatisticalController extends Controller
{
    public function commentPet(Request $request)
    {
        $product = Product::get();
        $count = '';

        if ($request->time) {
            foreach ($product as $pro) {
                $count .= $pro->reviews()->where('updated_at', 'like', '%' . $request->time . '%')->where('product_type', 1)->count() . ',';
            }
            return response()->json(['time' => $request->time, 'product' => $product, 'review' => $count]);
        }
        foreach ($product as $pro) {
            $count .= $pro->reviews()->where('product_type', 1)->count() . ',';
        }
        return view('admin.statistical.commentPet', compact('product', 'count'));
    }

    public function commentAccess(Request $request)
    {
        $product = Accessory::get();
        $count = '';
        if ($request->time) {
            foreach ($product as $pro) {
                $count .= $pro->reviews()->where('created_at', 'like', '%' . $request->time . '%')->where('product_type', 2)->count() . ',';
            }
            return response()->json(['time' => $request->time, 'product' => $product, 'review' => $count]);
        }
        foreach ($product as $pro) {
            $count .= $pro->reviews()->where('product_type', 2)->count() . ',';
        }

        return view('admin.statistical.commentAccess', compact('product', 'count'));
    }

    public function orderPet(Request $request)
    {
        $year = Order::select(DB::raw('Year(created_at) as year'))
            ->groupBy(DB::raw("Year(created_at)"))
            ->pluck('year');

        $orderData = Order::get();
        $month = Order::select(DB::raw('Month(created_at) as month'));
        $order = Order::select(DB::raw('COUNT(*) as count'));
        if ($request->time) {
            $order = $order->whereYear('created_at', $request->time)
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('count');
            $month = $month->whereYear('created_at', $request->time)
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('month');

            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($month as $index => $mon) {
                $data[$mon - 1] = $order[$index];
            }
            return response()->json(['data' => $data, 'year' => $month]);
        }

        $order = $order->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');

        $month = $month->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');


        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($month as $index => $mon) {
            $data[$mon - 1] = $order[$index];
        }
        return view('admin.statistical.orderPet', compact('data', 'orderData', 'year'));
    }

    public function detail($id)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        $product = Product::find($id);
        $review =  $product->load('reviews')->reviews()->get();
        return view('admin.statistical.detail', compact('product', 'review', 'admin'));
    }

    public function getDetail(Request $request, $id)
    {
        $review = Review::select('reviews.*')->where('product_id', $id);
        return dataTables::of($review)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('gender.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a  class="btn btn-success" href="' . route('gender.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('gender.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('comment', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox', 'product'])
            ->make(true);
    }


    public function block($id, Request $request)
    {
        $review = Review::withTrashed()->find($id);
        if (!$review) {
            return redirect()->back()->with('BadState', 'review có id là ' . $id . 'không tồn tại');
        }
        $review->delete();
    }
}