<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $fillable = [
        'name','status','show_menu',
    ];
    public function books(){
        return $this->hasMany(Book::class, 'cate_id');
    }
}
