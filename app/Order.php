<?php

namespace App;

use App\Http\Controllers\NotificationController;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

require_once app_path() . "/lib/Wxpay/WxPay.Api.php";

class Order extends Model
{
    use softDeletes;

    protected $fillable = [
        'customer_id', 'product_id', 'count', 'name', 'phone', 'channel', 'store_id', 'desc', 'address', 'pay_status',
        'groupbuy_id', 'deliver_code', 'spec_id', 'price', 'status', 'number', 'trade_no', 'refund_reason', 'refund_reason_other',
        'formid', 'formid_group'
    ];

    public $timestamps = true;

    protected $table = 'orders';

    protected $appends = [
    ];

    const STATUS_GROUPBUY_WAITING = 1;
    const STATUS_GROUPBUY_CANCELLED = 2;
    const STATUS_INIT = 5;
    const STATUS_SENT = 10;
    const STATUS_RECEIVED = 15;
    const STATUS_REFUND_REQUESTED = 20;
    const STATUS_REFUNDED = 25;

    /**
     * 状态列表
     * @var array
     */
    public static $STATUS_LIST = [
        Order::STATUS_GROUPBUY_WAITING,
        Order::STATUS_GROUPBUY_CANCELLED,
        Order::STATUS_INIT,
        Order::STATUS_SENT,
        Order::STATUS_RECEIVED,
        ORder::STATUS_REFUND_REQUESTED,
        Order::STATUS_REFUNDED,
    ];

    const DELIVER_EXPRESS = 0;
    const DELIVER_SELF = 1;

    const STATUS_PAY_PAID = 0;
    const STATUS_PAY_REFUNDED = 1;

    const REFUND_GROUPBUY_CANCEL = 1;
    const REFUND_OTHER = 2;

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
    public static function getStatusName($status, $channel) {
        switch($status) {
            case Order::STATUS_GROUPBUY_WAITING:
                return "拼团中";
            case Order::STATUS_GROUPBUY_CANCELLED:
                return "已取消";
            case Order::STATUS_INIT:
                if ($channel == Order::DELIVER_EXPRESS) {
                    return "待发货";
                }
                else {
                    return "待提货";
                }
            case Order::STATUS_SENT:
                if ($channel == Order::DELIVER_EXPRESS) {
                    return "待收货";
                }
                else {
                    return "待提货";
                }
            case Order::STATUS_RECEIVED:
                if ($channel == Order::DELIVER_EXPRESS) {
                    return "已收货";
                }
                else {
                    return "已提货";
                }
            case Order::STATUS_REFUND_REQUESTED:
                return "退款审核中";

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
        return $this->belongsTo('App\Groupbuy', 'groupbuy_id')->withTrashed();
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
        return $this->belongsTo('App\Product')->withTrashed();
    }

    /**
     * 获取商品规格
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spec() {
        return $this->belongsTo('App\Spec')->withTrashed();
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

    /**
     * 查看拼团是否成功
     */
    public function checkGroupBuy() {
        $groupBuy = $this->groupBuy;
        $product = $this->product;

        if (empty($groupBuy)) {
            return;
        }

        if ($groupBuy->getPeopleCount() == $product->gb_count) {

            $nctrl = new NotificationController();
            $strToken = $nctrl->getAccessToken();

            foreach ($groupBuy->orders as $order) {
                $order->status = Order::STATUS_INIT;
                $order->save();
                $order->addStatusHistory();

                //
                // 推送消息，拼团成功
                //
                $params = array();
                $params["keyword1"] = [
                    "value" => $product->name,
                ];
                $params["keyword2"] = [
                    "value" => $order->price,
                ];
                $params["keyword3"] = [
                    "value" => $product->gb_count,
                ];
                $params["keyword4"] = [
                    "value" => "24小时之内",
                ];

                $nctrl->sendPushNotification($strToken, [
                    "touser" => $order->customer->wechat_id,
                    "template_id" => "e5m9kx7gcP46tjSfJVa1d1W-Pn6W7UXxAjtA4Pry97M",
                    "form_id" => $order->formid_group,
                    "data" => $params,
                ]);
            }

            $groupBuy->delete();
        }
    }

    /**
     * 进行退款
     * @return \成功时返回，其他抛异常
     */
    public function refundOrder() {

        $strRefundNo = time() . uniqid();

        $input = new \WxPayRefund();
        $input->SetOut_trade_no($this->trade_no);
        $input->SetTotal_fee($this->price * 100);
        $input->SetRefund_fee($this->price * 100);
        $input->SetOut_refund_no($strRefundNo);
        $input->SetOp_user_id(\WxPayConfig::MCHID);

        $refundInfo = \WxPayApi::refund($input);

        if ($refundInfo['result_code'] == "SUCCESS") {
            // 成功
            $this->status = Order::STATUS_REFUNDED;
            $this->save();

            // 添加订单状态历史
            $this->addStatusHistory();
        }

        return $refundInfo;
    }
}
