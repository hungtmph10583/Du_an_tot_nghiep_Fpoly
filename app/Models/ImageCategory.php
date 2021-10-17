<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCategory extends Model
{
    use HasFactory;
    protected $table = 'image_categories';
    protected $fillable = [
        'category_id',
        'image',
    ];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
