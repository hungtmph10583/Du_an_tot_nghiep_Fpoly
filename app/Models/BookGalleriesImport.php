<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookGalleriesImport extends Model
{
    use HasFactory;

    protected $table = 'book_galleries';
    public $fillable = ['url', 'order_no', 'book_id'];
}