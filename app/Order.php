<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use softDeletes;

    protected $fillable = [
        'customer_id', 'product_id', 'count', 'name', 'phone', 'channel', 'store_id', 'desc', 'address', 'pay_status',
        'groupbuy_id', 'deliver_code', 'spec_id', 'price', 'status'
    ];

    public $timestamps = true;

    protected $table = 'orders';

    protected $appends = [
    ];

    const STATUS_GROUPBUY_WAITING = 1;
    const STATUS_INIT = 5;
    const STATUS_SENT = 10;
    const STATUS_RECEIVED = 15;
    const STATUS_REFUNDED = 20;

    const DELIVER_EXPRESS = 0;
    const DELIVER_SELF = 1;

    const STATUS_PAY_PAID = 0;
    const STATUS_PAY_REFUNDED = 1;

    /**
     * 获取配送方式名称
     * @return string
     */
    public function getDeliveryName() {
        if ($this->channel == Order::DELIVER_EXPRESS) {
            return "发货";
        } else {
            return "自提";
        }
    }

    /**
     * 获取状态名称
     * @param $status
     * @return string
     */
    public static function getStatusName($status) {
        switch($status) {
            case Order::STATUS_GROUPBUY_WAITING:
                return "拼团中";
            case Order::STATUS_INIT:
                return "待发货";
            case Order::STATUS_SENT:
                return "待收货";
            case Order::STATUS_RECEIVED:
                return "已收货";
            case Order::STATUS_REFUNDED:
                return "已退款";
        }
    }

    /**
     * 获取状态历史
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories() {
        return $this->hasMany('App\OrderHistory');
    }

    /**
     * 获取拼团信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupBuy() {
        return $this->belongsTo('App\Groupbuy', 'groupbuy_id');
    }

    /**
     * 获取客户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo('App\Model\Customer');
    }

    /**
     * 获取商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() {
        return $this->belongsTo('App\Product');
    }

    /**
     * 获取商品规格
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spec() {
        return $this->belongsTo('App\Spec');
    }

    /**
     * 获取门店
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store() {
        return $this->belongsTo('App\Store');
    }

    /**
     * 添加订单状态历史
     */
    public function addStatusHistory() {
        $aryParam = [
            'order_id' => $this->id,
            'status' => $this->status,
        ];

        OrderHistory::create($aryParam);
    }
}
