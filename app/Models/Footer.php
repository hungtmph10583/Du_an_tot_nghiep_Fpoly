<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;
    protected $table = 'footers';

    protected $fillable = [
        'type',
        'content',
        'url',
        'general_setting_id'
    ];

    public function generalSetting(){
        return $this->hasMany(GeneralSetting::class, 'general_setting_id');
    }
}
