<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FooterTitle extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "footer_titles";
    protected $fillable = ['name', 'status'];

    public function footer()
    {
        return $this->belongsTo(Footer::class, 'id', 'footer_title_id')->withTrashed();
    }
}