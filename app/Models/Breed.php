<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;
    protected $table = "breeds";
    protected $fillable = [
        'name', 'slug', 'category_id', 'user_id', 'image', 'status'
    ];
    public function products()
    {
        return $this->hasMany(Product::class,'breed_id');
        // quan he 
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
