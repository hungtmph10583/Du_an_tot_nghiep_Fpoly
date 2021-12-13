<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Footer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'footers';
    protected $fillable = [
        'type', 'content', 'icon', 'url', 'general_setting_id'
    ];

    public function generalSetting()
    {
        return $this->hasMany(GeneralSetting::class, 'id', 'general_setting_id')->withTrashed();
    }
}