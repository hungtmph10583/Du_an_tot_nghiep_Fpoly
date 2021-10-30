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
        'image',
        'content',
        'status'
    ];

    public function BlogCategory(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function User(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
