<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'desc'];

    protected $table = 'category';

    public $timestamps = false;

    protected $appends = [
        'products',
    ];

    public function getProductsAttribute() {
        $ps = Product::where('category_id', $this->id)->get();

        return $ps;
    }
}
