<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'rtf_content', 'thumbnail', 'price', 'deliver_cost', 'gb_count', 'gb_price', 'gb_timeout',
        'remain',
    ];

    protected $appends = ['category_name'];

    public $timestamps = true;
    public $table = 'product';

    public function getCategoryNameAttribute() {
        $c = Category::find($this->category_id);
        return $c->name;
    }

    public function hasSpec($spec_id) {
        $s = ProductSpec::where('product_id', $this->id)->where('spec_id', $spec_id)->first();

        if($s == null)
            return false;
        else
            return true;
    }

    /**
     * 获取图片url
     * @return string
     */
    public function getThumbnailUrl() {
        return asset('uploads/product/'. $this->thumbnail);
    }
}
