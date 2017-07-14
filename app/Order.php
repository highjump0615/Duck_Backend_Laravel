<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'product_id', 'count', 'name', 'phone', 'channel', 'store_id', 'desc', 'address', 'pay_status',
        'groupbuy_id', 'deliver_code', 'spec_id',
    ];

    public $timestamps = true;

    protected $table = 'orders';

    protected $appends = [
        'customer_name', 'product_name', 'spec_name', 'deliver_mode_str', 'status_str', 'product_category_name', 'group',
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
        return $p->category_name;
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

    public function getGroupAttribute() {
        $gid = $this->groupbuy_id;
        $g = Groupbuy::find($gid);

        return $g;
    }
}
