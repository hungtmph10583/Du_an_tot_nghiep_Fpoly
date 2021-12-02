<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
        'product_id',
        'product_type',
        'user_id',
        'rating',
        'comment',
        'status'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function accessory(){
        return $this->belongsTo(Accessory::class, 'accessory_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
