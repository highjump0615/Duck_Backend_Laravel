<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use softDeletes;

    protected $fillable = [
        'customer_id', 'product_id', 'count', 'name', 'phone', 'channel', 'store_id', 'desc', 'address', 'pay_status',
        'groupbuy_id', 'deliver_code', 'spec_id',
    ];

    public $timestamps = true;

    protected $table = 'orders';

    protected $appends = [
        'customer_name', 'product_name', 'spec_name', 'deliver_mode_str', 'status_str', 'product_category_name',
    ];

    const STATUS_GROUPBUY_WAITING = 1;
    const STATUS_INIT = 5;
    const STATUS_SENT = 10;
    const STATUS_RECEIVED = 15;
    const STATUS_REFUNDED = 20;

    public function getCustomerNameAttribute() {
        $c = Customer::find($this->customer_id);
        return $c->name;
    }

    public function getProductNameAttribute() {
        $p = Product::find($this->product_id);
        return $p->name;
    }

    public function getProductCategoryNameAttribute() {
        $p = Product::find($this->product_id);
        return $p->category->name;
    }

    public function getSpecNameAttribute() {
        $s = Spec::find($this->spec_id);
        return $s->name;
    }

    public function getDeliverModeStrAttribute() {
        if(empty($this->store_id)) {
            return "发货";
        } else {
            return "自提";
        }
    }

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

    public function histories() {
        return $this->hasMany('App\OrderHistory');
    }

    /**
     * 获取拼团信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupBuy() {
        return $this->belongsTo('App\Groupbuy');
    }

    /**
     * 获取客户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo('App\Model\Customer');
    }
}
