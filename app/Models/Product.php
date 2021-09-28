<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name','slug','image','weight','creator','price','status','quantity','description'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'cate_id');
    }

    // public function company(){
    //     return $this->belongsTo(Company::class, 'comp_id');
    // }

    // public function galleries(){
    //     return $this->hasMany(ProductGallery::class, 'product_id');
    // }

    // public function product_tag(){
    //     return $this->hasMany(ProductTag::class, 'product_id');
    // }
}
