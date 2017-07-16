<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'phone', 'notice_refund', 'notice_groupbuy',
    ];

    protected $hidden = [
        'id'
    ];

    public $timestamps = false;

    protected $table = "settings";
}
