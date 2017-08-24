<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable = ['name', 'desc', 'sequence'];

    protected $table = 'category';

    public $timestamps = false;
    use softDeletes;

    /**
     * 获取本分类的所有产品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany('App\Product');
    }
}
