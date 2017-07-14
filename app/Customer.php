<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected  $fillable = [
        'name', 'wechat_id', 'image_url',
    ];

    public $timestamps = false;

    protected $table = 'customer';

    
}
