<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    public $fillable = ['name', 'status', 'show_menu'];

    public function product()
    {
        return $this->hasMany('App\Models\products', 'cate_id');
    }
    public function book()
    {
        return $this->hasMany('App\Models\Book', 'cate_id');
    }
}