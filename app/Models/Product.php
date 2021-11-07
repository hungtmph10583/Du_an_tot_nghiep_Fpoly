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
        'user_id',
        'category_id',
        'slug',
        'weight',
        'breed_id',
        'age_id',
        'counpon_id',
        'gender_id',
        'rating',
        'price',
        'coupon_id',
        'discount',
        'discount_type',
        'min_quantity',
        'discount_start_date',
        'discount_end_date',
        'status',
        'quantity',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function age()
    {
        return $this->belongsTo(Age::class, 'age_id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id');
    }

    public function discountType()
    {
        return $this->belongsTo(DiscountType::class, 'discount_type');
    }

    public function reviews()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}