<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }
    public function getData(Request $request)
    {
        $cate = Category::with('book')->select('categories.*');
        return dataTables::of($cate)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addIndexColumn()
            ->orderColumn('status', function ($row, $order) {
                return $row->orderBy('status', $order);
            })
            ->addColumn('so-luong', function ($row) {
                return $row->book()->count();
            })
            ->orderColumn('so-luong', function ($row, $order) {
                return  $row->join('books', 'books.cate_id', '=', 'categories.id')
                    ->groupBy('categories.id')
                    ->orderByRaw("count(books.cate_id)$order");
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
            // lấy ra tất cả thể loại sách
            // ->addColumn('genres', function (Book $row) {
            //     return $row->genres->map(function ($blog) {
            //         return $blog->name;
            //     })->implode(',', ",");
            // })
            // lấy ra tất cả tác giả sách
            // ->addColumn('author', function (Book $row) {
            //     return $row->authors->map(function ($blog) {
            //         return $blog->name;
            //     })->implode(',', ",");
            // })
            ->addColumn('action', function ($row) {
                return '<a  class="btn btn-success" href="' . route('book.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" href="javascript:void(0);" onclick="deleteBook(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
<a class="btn btn-primary" href="' . route("book.detail", ["id" => $row->id]) . '"><i class="far fa-eye"></i></a>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '2') {
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
}