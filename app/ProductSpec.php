<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
    protected $fillable = [
        'product_id', 'spec_id',
    ];

    public $timestamps = false;
}
