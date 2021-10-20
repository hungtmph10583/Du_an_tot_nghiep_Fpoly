<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'title',
        'slug',
        'creator',
        'image',
        'content',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'creator');
    }
}
