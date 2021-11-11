<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'note',
        'shipping_address',
        'payment_type',
        'payment_status',
        'delivery_status',
        'grand_total',
        'coupon_discount',
        'code'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
        // quan he 
    }
}
