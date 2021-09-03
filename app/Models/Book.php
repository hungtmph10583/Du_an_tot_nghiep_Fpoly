<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    public $fillable = ['name', 'cate_id', 'country_id', 'price', 'status', 'quantity', 'detail'];

    function categories()
    {
        return $this->belongsTo('App\Models\Category', 'cate_id');
    }

    public function countries()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function galleries()
    {
        return $this->hasMany(BookGallery::class, 'book_id');
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author', 'book_id', 'author_id');
    }
    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'book_genres', 'book_id', 'genre_id');
    }
}