<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupbuy extends Model
{
    protected $table="groupbuy";

    protected $fillable = [
        'persons', 'end_at',
    ];

    
}
