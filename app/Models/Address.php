<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'addresses';
    protected $fillable = [
        'user_id',
        'address',
        'city_id',
        'postal_code'
    ];
    public function user()
    {
        return $this->belongsTo(Product::class, 'user_id');
    }
    public function city()
    {
        return $this->belongsToMany(City::class, 'city_id');
    }
}