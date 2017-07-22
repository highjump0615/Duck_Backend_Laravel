<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spec extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
    use softDeletes;

    protected $table = 'specs';
}
