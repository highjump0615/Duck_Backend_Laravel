<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Ad extends Model
{
    protected $fillable = [
        'product_id', 'image_url', 'start_at', 'end_at',
    ];

    protected $appends = [
        'image_full_path',
    ];

    public $timestamps = true;

    public function product() {
        return $this->belongsTo('App\Product')->withTrashed();
    }

    public function getImageFullPathAttribute() {
        if(!empty($this->image_url)) {
            return asset($this->image_url);
        } else {
            return null;
        }
    }

    public function getStartAtAttribute($value) {
        $date = new DateTime($value);
        return $date->format('Y-m-d');
    }

    public function getEndAtAttribute($value) {
        $date = new DateTime($value);
        return $date->format('Y-m-d');
    }
}
