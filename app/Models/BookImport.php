<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImport extends Model
{
    use HasFactory;
    protected $table = 'books';
    public $fillable = ['name', 'cate_id', 'country_id', 'image', 'price', 'status', 'quantity', 'detail'];
}