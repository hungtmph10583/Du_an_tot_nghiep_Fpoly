<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = [
        'name', 'slug', 'status'
    ];
    // Quan hệ category -> product
    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
        // quan he 
    }
}
