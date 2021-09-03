<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    public $fillable = ['name', 'ensign'];

    public function book()
    {
        return $this->hasMany('App\Models\Country', 'country_id');
    }
}