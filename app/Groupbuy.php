<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Groupbuy extends Model
{
    protected $table="groupbuy";

    protected $fillable = [
        'end_at',
    ];

    /**
     * 获取订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }

    /**
     * 获取剩余时间（秒）
     * @return int
     */
    public function getRemainTime() {
        $dateCurrent = new DateTime("now");
        $dateEnd = new DateTime($this->end_at);

        return $dateEnd->getTimestamp() - $dateCurrent->getTimestamp();
    }

    /**
     * 获取人数
     * @return mixed
     */
    public function getPeopleCount() {
        return $this->orders()->count();
    }
}
