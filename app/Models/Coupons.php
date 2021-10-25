<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $table = "coupons";
    protected $fillable = [
        'user_id', 'discount_type_id','quantity', 'code',  'details', 'discount', 'start_date', 'end_date'
    ];
    public function DiscountType(){
        return $this->belongsTo(Category::class, 'discount_type_id');
    }
}
