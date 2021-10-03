<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'category_id',
        'breed_id',
        'slug',
        'image',
        'weight',
        'gender_id',
        'creator',
        'price',
        'status',
        'quantity',
        'detail'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function breed(){
        return $this->belongsTo(Breed::class, 'breed_id');
    }

    public function gender(){
        return $this->belongsTo(Gender::class, 'gender_id');
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
