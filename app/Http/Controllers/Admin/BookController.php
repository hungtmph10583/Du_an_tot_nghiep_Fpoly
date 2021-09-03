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

class BookController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 5;
        $searchData = $request->except('page');

        if (count($request->all()) == 0) {
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $books = Book::paginate($pagesize);
        } else {
            $bookQuery = Book::where('name', 'like', "%" . $request->keyword . "%");

            if ($request->has('order_by') && $request->order_by > 0) {
                if ($request->order_by == 1) {
                    $bookQuery = $bookQuery->orderBy('name');
                } else {
                    $bookQuery = $bookQuery->orderByDesc('name');
                }
            }
            $books = $bookQuery->paginate($pagesize)->appends($searchData);
        }
        return view('admin.book.index', [
            'books' => $books
        ]);
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
        dd(1);
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