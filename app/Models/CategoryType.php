<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryType extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name', 'slug'
    ];
    // Quan hệ category -> blog
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_blog_id');
        // quan he 
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'category_type_id');
    }
}