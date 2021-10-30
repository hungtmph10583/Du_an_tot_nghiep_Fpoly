<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug'
    ];
    // Quan hệ category -> blog
    public function blogs()
    {
        return $this->hasMany(Blog::class,'category_blog_id');
        // quan he 
    }
}
