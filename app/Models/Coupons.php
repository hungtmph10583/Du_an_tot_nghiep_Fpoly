<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupons extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "coupons";
    protected $fillable = [
        'type', 'code', 'user_id', 'discount', 'discount_type', 'start_date', 'end_date'
    ];

    public function couponType()
    {
        return $this->belongsTo(CouponType::class, 'type')->withTrashed();
    }

    public function discountType()
    {
        return $this->belongsTo(Category::class, 'discount_type')->withTrashed();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'coupon_id')->withTrashed();
    }

    public function couponUsage()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id')->withTrashed();
    }

    public function accessory()
    {
        return $this->hasMany(Accessory::class, 'coupon_id')->withTrashed();
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'coupon_id')->withTrashed();
    }
}