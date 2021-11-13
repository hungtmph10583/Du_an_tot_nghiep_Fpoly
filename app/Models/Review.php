<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'reviews';
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Category::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}