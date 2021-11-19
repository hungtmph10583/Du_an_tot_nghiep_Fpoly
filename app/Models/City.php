<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cities';
    protected $fillable = [
        'country_id',
        'name',
        'cost'
    ];
    public function address()
    {
        return $this->hasMany(Address::class, 'city_id');
    }
}