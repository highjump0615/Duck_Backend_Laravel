<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id', 'status',
    ];

    protected $table = "order_histories";

    protected $appends = [
        'status_str',
    ];

    public function getStatusStrAttribute() {
        $s = $this->status;

        switch($s) {
            case Order::STATUS_GROUPBUY_WAITING:
                return "拼团中";
            case Order::STATUS_INIT:
                return "代发货";
            case Order::STATUS_SENT:
                return "待收货";
            case Order::STATUS_RECEIVED:
                return "已收货";
            case Order::STATUS_REFUNDED:
                return "已退款";
        }
    }
}
