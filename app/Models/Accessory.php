<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;
    protected $table = 'accessories';
    protected $fillable = [
        'name',
        'creator',
        'category_id',
        'slug',
        'image',
        'price',
        'coupon_id',
        'discount',
        'discount_type',
        'min_quantity',
        'discount_start_date',
        'discount_end_date',
        'status',
        'quantity',
        'description',
        'detail'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function galleries(){
        return $this->hasMany(AccessoryGallery::class, 'accessory_id');
    }
}
