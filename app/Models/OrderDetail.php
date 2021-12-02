<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'tax',
        'shipping_cost',
        'shipping_type',
        'payment_status',
        'delivery_status',
        'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function accessory()
    {
        return $this->belongsTo(Accessory::class, 'product_id');
    }
}
