<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;
use App\Models\ProductTag;
use App\Models\Category;
use App\Models\Company;
use App\Models\ProductGallery;

class ProductController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $products = Product::paginate($pagesize);
        }else{
            $productQuery = Product::where('name', 'like', "%" .$request->keyword . "%");
            if($request->has('cate_id') && $request->cate_id != ""){
                $productQuery = $productQuery->where('cate_id', $request->cate_id);
            }
            if($request->has('comp_id') && $request->comp_id != ""){
                $productQuery = $productQuery->where('comp_id', $request->comp_id);
            }

            if($request->has('order_by') && $request->order_by > 0){
                if($request->order_by == 1){
                    $productQuery = $productQuery->orderBy('name');
                }else if($request->order_by == 2){
                    $productQuery = $productQuery->orderByDesc('name');
                }else if($request->order_by == 3){
                    $productQuery = $productQuery->orderBy('price');
                }else {
                    $productQuery = $productQuery->orderByDesc('price');
                }
            }
            $products = $productQuery->paginate($pagesize)->appends($searchData);
        }
        $products->load('category', 'tags', 'company', 'galleries', 'product_tag');
        
        $cates = Category::all();
        $tag = Tag::all();
        $productT = ProductTag::all();
        $productG = ProductGallery::all();
        $comp = Company::all();
        
        // trả về cho người dùng 1 giao diện + dữ liệu products vừa lấy đc 
        return view('admin.product.index', [
            'data_product' => $products, 
            'cates' => $cates,
            'comp' => $comp,
            'productG' => $productG,
            'searchData' => $searchData
        ]);
    }

    public function remove($id){
        $product = Product::find($id);
        $product->product_tag()->delete();
        $product->delete();
        return redirect()->back();
    }

    public function addForm(){
        $cates = Category::all();
        $comp = Company::all();
        $tags = Tag::all();
        return view('admin.product.add-form', compact('cates', 'comp', 'tags'));
    }

    public function saveAdd(ProductFormRequest $request){
        $model = new Product(); 
        
        $model->fill($request->all());
        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->image = $request->file('uploadfile')->storeAs('uploads/products', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }

        $model->save();
        if($request->has('tag_id')){
            foreach($request->tag_id as $tg => $item){
                $productTagObj = new ProductTag();
                $productTagObj->product_id = $model->id;
                $productTagObj->tag_id = $item;
                $productTagObj->save();
            }
        }

        if($request->has('galleries')){
            foreach($request->galleries as $i => $item){
                $galleryObj = new ProductGallery();
                $galleryObj->product_id = $model->id;
                $galleryObj->order_no = $i+1;
                $galleryObj->url = $item->storeAs('uploads/products/galleries/' . $model->id , 
                                        uniqid() . '-' . $request->uploadfile->getClientOriginalName());
                $galleryObj->save();
            }
        }
        return redirect(route('product.index'));
    }

    public function editForm($id){
        $model = Product::find($id);
        if(!$model){
            return redirect()->back();
        }

        $cates = Category::all();
        $comp = Company::all();
        $tags = Tag::all();
        $product_tag = ProductTag::all();

        $model->load('galleries', 'product_tag', 'tags');
        return view('admin.product.edit-form', compact('model', 'cates', 'comp', 'tags', 'product_tag'));
    }

    public function saveEdit($id, ProductFormRequest $request){
        $model = Product::find($id); 
        
        if(!$model){
            return redirect()->back();
        }
        $model->fill($request->all());
        // upload ảnh
        if($request->hasFile('uploadfile')){
            $model->image = $request->file('uploadfile')->storeAs('uploads/products', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();
        if($request->has('tag_id')){
            $removePrt = ProductTag::where("product_id", $id)->get();
            foreach($removePrt as $rmv){
                $rmv->delete();
            }
            foreach($request->tag_id as $tg => $item){
                $productTagObj = new ProductTag();
                $productTagObj->product_id = $model->id;
                $productTagObj->tag_id = $item;
                $productTagObj->save();
            }
        }else{
            $removePrt = ProductTag::where("product_id", $id)->get();
            foreach($removePrt as $rmv){
                $rmv->delete();
            }
        }
        // gallery
        // xóa gallery đc mark là bị xóa đi
        if($request->has('removeGalleryIds')){
            $strIds = rtrim($request->removeGalleryIds, '|');
            $lstIds = explode('|', $strIds);
            // xóa các ảnh vật lý
            $removeList = ProductGallery::whereIn('id', $lstIds)->get();
            foreach ($removeList as $gl) {
                Storage::delete($gl->url);
            }
            
            ProductGallery::destroy($lstIds);
        }

        // lưu mới danh sách gallery
        if($request->has('galleries')){
            foreach($request->galleries as $i => $item){
                $galleryObj = new ProductGallery();
                $galleryObj->product_id = $model->id;
                $galleryObj->order_no = $i+1;
                $galleryObj->url = $item->storeAs('uploads/products/galleries/' . $model->id , 
                                        uniqid() . '-' . $item->getClientOriginalName());
                $galleryObj->save();
            }
        }
        return redirect(route('product.index'));
    }
}