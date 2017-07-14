<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
    protected $table = 'specs';
}
