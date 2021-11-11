<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'category_blog_id',
        'image',
        'content',
        'status'
    ];

    public function blogCategory(){
        return $this->belongsTo(User::class, 'category_blog_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
