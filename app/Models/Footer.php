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
        'footer_title_id', 'type', 'content', 'icon', 'url', 'general_setting_id'
    ];

    public function footerTitle()
    {
        return $this->hasMany(FooterTitle::class, 'id', 'footer_title_id')->withTrashed();
    }

    public function generalSetting()
    {
        return $this->hasMany(GeneralSetting::class, 'id', 'general_setting_id')->withTrashed();
    }
}