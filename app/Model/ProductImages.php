<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'url'
    ];

    public $timestamps = false;

    public function getImageUrl() {
        return asset('uploads/product/'. $this->url);
    }
}
