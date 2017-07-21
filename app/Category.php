<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'desc'];

    protected $table = 'category';

    public $timestamps = false;

    /**
     * 获取本分类的所有产品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany('App\Product');
    }
}
