<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookGenres extends Model
{
    use HasFactory;

    protected $table = 'book_genres';
    public $fillable = ['order_no', 'genre_id', 'book_id'];
}