<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookGallery;
use App\Models\BookGenres;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $orderArray = [
            0 => [
                "id" => 1,
                "name" => "Tên alphabeta",
            ],
            1 => [
                "id" => 2,
                "name" => "Tên tăng dần alphabeta",
            ],
            2 => [
                "id" => 3,
                "name" => "Giá tăng dần",
            ],
            3 => [
                "id" => 4,
                "name" => "Giá giảm dần",
            ],
            4 => [
                "id" => 5,
                "name" => "Số lượng tăng dần",
            ],
            5 => [
                "id" => 6,
                "name" => "Số lượng giảm dần",
            ],
        ];
        $pagesize = 5;
        $searchData = $request->except('page');
        $category = Category::get();
        $author = Author::get();
        $country = Country::get();
        $genres = Genres::get();

        if (count($request->all()) == 0) {
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $books = Book::paginate($pagesize);
        } else {
            $bookQuery = Book::where('name', 'like', "%" . $request->keyword . "%");

            if ($request->country != '') {
                $bookQuery = $bookQuery
                    ->where('country_id', $request->country);
            }

            if ($request->status != '') {
                $bookQuery = $bookQuery
                    ->where('status', $request->status);
            }

            if ($request->cate != '') {
                $bookQuery = $bookQuery
                    ->where('cate_id', $request->cate);
            }

            if ($request->genres != '') {
                $bookQuery = $bookQuery
                    ->join('book_genres', 'book_genres.book_id', '=', 'books.id')
                    ->join('book_author', 'book_author.book_id', '=', 'books.id')
                    ->where('book_genres.genre_id', $request->genres);
            } elseif ($request->author != '') {
                $bookQuery = $bookQuery
                    ->join('book_genres', 'book_genres.book_id', '=', 'books.id')
                    ->join('book_author', 'book_author.book_id', '=', 'books.id')
                    ->where('book_author.book_id', $request->author);
            } else if ($request->genres != '' && $request->author != '') {
                $bookQuery = $bookQuery
                    ->join('book_genres', 'book_genres.book_id', '=', 'books.id')
                    ->join('book_author', 'book_author.book_id', '=', 'books.id')
                    ->where('book_genres.genre_id', $request->genres)
                    ->where('book_author.book_id', $request->author);
            };

            if ($request->has('order_by') && $request->order_by > 0) {
                switch ($request->order_by) {
                    case '1':
                        $bookQuery = $bookQuery->orderBy('name');
                        break;
                    case '2':
                        $bookQuery = $bookQuery->orderByDesc('name');
                        break;
                    case '3':
                        $bookQuery = $bookQuery->orderBy('price');
                        break;
                    case '4':
                        $bookQuery = $bookQuery->orderByDesc('price');
                        break;
                    case '5':
                        $bookQuery = $bookQuery->orderBy('quantity');
                        break;
                    case '6':
                        $bookQuery = $bookQuery->orderByDesc('quantity');
                        break;
                }
            }
            $books = $bookQuery->paginate($pagesize)->appends($searchData);
        }
        return view('admin.book.index', compact('books', 'category', 'author', 'country', 'genres', 'searchData', 'orderArray'));
    }
    public function getData()
    {
        $book = Book::select('*');
        return dataTables::of($book)
            ->addIndexColumn()
            ->orderColumn('cate_id', function ($row, $order) {
                return $row->orderBy('cate_id', $order);
            })
            ->orderColumn('status', function ($row, $order) {
                return $row->orderBy('status', $order);
            })
            ->addColumn('cate_id', function ($row) use ($request) {
                $category = Category::get();
                foreach ($category as $cate) {
                    if ($row->cate_id == $cate->id) {
                        return $cate->name;
                    }
                }
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
            ->addColumn('action', function ($row) use ($request) {
                return $request->get('search');
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '3') {
                    $instance->where('status', $request->get('status'));
                }

                if ($request->get('cate') != '') {
                    $instance->where('cate_id', $request->get('cate'));
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('detail', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    public function detail($id)
    {
        $model = Book::find($id);
        $model->load('galleries');
        return view('admin.book.detail-book', ['detail' => $model]);
    }
    public function upload(Request $request)
    {
        $uploadImg = $request->file('file');
        $path = $uploadImg->storeAs('uploads/images', uniqid() . '.' . $uploadImg->extension());
        return json_encode(['location' => asset('storage/' . $path)]);
    }
    public function addForm()
    {
        $category = Category::get();
        $country = Country::get();
        $author = Author::get();
        $genres = Genres::get();

        return view('admin.book.add-form', compact('category', 'country', 'author', 'genres'));
    }

    public function saveAdd(BookRequest $request)
    {
        $model = new Book();
        $model->fill($request->all());
        if ($request->image != '') {
            $path = $request->file('image')->storeAs('uploads/images', uniqid() . '-' . $request->image->getClientOriginalName());
            $model->image = $path;
        }
        $model->save();
        if ($request->has('galleries')) {
            foreach ($request->galleries as $i => $item) {
                $galleryObj = new BookGallery();
                $galleryObj->book_id = $model->id;
                $galleryObj->order_no = $i + 1;
                $galleryObj->url = $item->storeAs(
                    'uploads/gallery/' . $model->id,
                    uniqid() . '-' . $item->getClientOriginalName()
                );
                $galleryObj->save();
            }
        }

        if ($request->author) {
            foreach ($request->author as $i => $a) {
                $mod = new BookAuthor();
                $mod->order_no = $i + 1;
                $mod->book_id = $model->id;
                $mod->author_id = $a;
                $mod->save();
            }
        }

        if ($request->genres) {
            foreach ($request->genres as $i => $g) {
                $mod = new BookGenres();
                $mod->order_no = $i + 1;
                $mod->book_id = $model->id;
                $mod->genre_id = $g;
                $mod->save();
            }
        }


        return Redirect::to("admin/sach");
    }

    public function editForm($id)
    {
        $category = Category::get();
        $country = Country::get();
        $author = Author::get();
        $genres = Genres::get();
        $model = Book::find($id);

        if (!$model) {
            return redirect()->back();
        }

        return view('admin.book.edit-form', compact('category', 'country', 'author', 'genres', 'model'));
    }

    public function saveEdit($id, BookRequest $request)
    {
        $model = Book::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $model->fill($request->all());
        if ($request->image != '') {
            $path = $request->file('image')->storeAs('uploads/images', uniqid() . '-' . $request->image->getClientOriginalName());
            $model->image = $path;
        }
        $model->save();

        if ($request->has('removeGalleryIds')) {
            $strIds = rtrim($request->removeGalleryIds, '|');
            $lstIds = explode('|', $strIds);
            // xóa các ảnh vật lý
            $removeList = BookGallery::whereIn('id', $lstIds)->get();
            foreach ($removeList as $gl) {
                Storage::delete($gl->url);
            }

            BookGallery::destroy($lstIds);
        }

        if ($request->has('galleries')) {
            $mod = BookGallery::where('book_id', $request->id);
            $mod->delete();
            foreach ($request->galleries as $i => $item) {
                $galleryObj = new BookGallery();
                $galleryObj->book_id = $model->id;
                $galleryObj->order_no = $i + 1;
                $galleryObj->url = $item->storeAs(
                    'uploads/gallery/' . $model->id,
                    uniqid() . '-' . $item->getClientOriginalName()
                );
                $galleryObj->save();
            }
        }

        if ($request->author) {
            $mod = BookAuthor::where('book_id', $request->id);
            $mod->delete();
            foreach ($request->author as $i => $a) {
                $mod = new BookAuthor();
                $mod->order_no = $i + 1;
                $mod->book_id = $model->id;
                $mod->author_id = $a;
                $mod->save();
            }
        } else {
            $mod = BookAuthor::where('book_id', $request->id);
            $mod->delete();
        }

        if ($request->genres) {
            $mod = BookGenres::where('book_id', $request->id);
            $mod->delete();
            foreach ($request->genres as $i => $g) {
                $mod = new BookGenres();
                $mod->order_no = $i + 1;
                $mod->book_id = $model->id;
                $mod->genre_id = $g;
                $mod->save();
            }
        } else {
            $mod = BookGenres::where('book_id', $request->id);
            $mod->delete();
        }
        return Redirect::to("admin/sach");
    }
    public function remove($id)
    {
        $model = Book::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $bookAuthor = BookAuthor::where('book_id', $id)->delete();

        $bookGallery = BookGallery::where('book_id', $id)->delete();

        $bookGenres = BookGenres::where('book_id', $id)->delete();

        $model->delete();
        return Redirect::to("admin/sach");
    }
}