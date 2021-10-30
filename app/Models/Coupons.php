<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $table = "coupons";
    protected $fillable = [
        'type', 'code', 'user_id', 'details', 'discount', 'discount_type', 'start_date', 'end_date'
    ];

    public function couponType(){
        return $this->belongsTo(CouponType::class, 'type');
    }

    public function discountType(){
        return $this->belongsTo(Category::class, 'discount_type');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'coupon_id');
    }
}
