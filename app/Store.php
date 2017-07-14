<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name', 'address', 'phone', 'longitude', 'latitude',
    ];

    public $timestamps = false;

    protected $table = 'store';
}
