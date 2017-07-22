<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'rtf_content', 'thumbnail', 'price', 'deliver_cost', 'gb_count', 'gb_price', 'gb_timeout',
        'remain',
    ];

    protected $appends = [];

    public $timestamps = true;
    use softDeletes;

    public $table = 'product';

    /**
     * 获取分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo('App\Category')->withTrashed();
    }

    public function hasSpec($spec_id) {
        $s = ProductSpec::where('product_id', $this->id)
            ->where('spec_id', $spec_id)
            ->first();

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

    /**
     * 获取图片
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Model\ProductImages');
    }

    /**
     * 获取规格
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specs() {
        return $this->belongsToMany('App\Spec', 'product_specs');
    }
}
