<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Statistical;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $model = new Statistical();
        // $models = Statistical::where('product_id', 1)
        //     ->where('created_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')->first();
        // if ($models) {
        //     $models->quantity += 11;
        //     $models->save();
        // } else {
        //     dd(1);
        // }

        return view('admin.dashboard.index');
    }
}