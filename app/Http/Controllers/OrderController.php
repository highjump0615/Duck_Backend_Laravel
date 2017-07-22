<?php

namespace App\Http\Controllers;

use App\Groupbuy;
use App\Model\Customer;
use App\Order;
use App\Product;
use DateTime;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

require_once app_path() . "/lib/Wxpay/WxPay.Api.php";

class OrderController extends Controller
{
    public $menu = 'order';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    /**
     * 打开订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getOrderList(Request $request) {
        $orders = Order::with('product')
            ->with('spec')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('order.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
            'orders'=> $orders,
        ]));
    }

    /**
     * 打开订单详情页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrder(Request $request, $id) {
        $order = Order::find($id);
        return view('order.detail', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
            'order'=>$order
        ]));
    }
    
    public function updateOrder(Request $request, $id) {
        $order = Order::find($id);
        
        if($request->has('deliver_code')) {
            $order->deliver_code = $request->input('deliver_code');
            $order->status = Order::STATUS_SENT;

            $order->save();
            $order->addStatusHistory();
        }

        return redirect()->to(url('/order')."/detail/".$id);
    }

    /**
     * 预支付处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prepareOrderApi(Request $request) {
        $nProductId = $request->input('product_id');
        $dPrice = $request->input('price');
        $nCustomerId = $request->input('customer_id');

        $product = Product::find($nProductId);
        $customer = Customer::find($nCustomerId);

        // 预支付
        $worder = new \WxPayUnifiedOrder();

        $worder->SetBody($product->name);
        $worder->SetOut_trade_no(time() . uniqid() );
        $worder->SetTotal_fee(intval($dPrice * 100));
        $worder->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $worder->SetTrade_type("JSAPI");

        $worder->SetOpenid($customer->wechat_id);

        $payOrder = \WxPayApi::unifiedOrder($worder);

        return response()->json([
            'status' => 'success',
            'result' => $payOrder,
        ]);
    }

    /**
     * 下单API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeOrderApi(Request $request) {
        $nProductId = $request->input('product_id');
        $nCount = $request->input('count');
        $product = Product::find($nProductId);

        $order = new Order();

        // 设置基础参数
        $order->customer_id     = $request->input('customer_id');
        $order->product_id      = $nProductId;
        $order->count           = $nCount;
        $order->name            = $request->input('name');
        $order->phone           = $request->input('phone');
        $order->spec_id         = $request->input('spec_id');
        $order->channel         = $request->input('channel');
        $order->desc            = $request->input('desc');
        $order->price           = $request->input('price');
        $order->pay_status      = Order::STATUS_PAY_PAID;
        $order->status          = Order::STATUS_INIT;

        // 门店自提
        if ($request->has('store_id')) {
            $order->store_id = $request->input('store_id');
        }
        // 快递
        if ($request->has('address')) {
            $order->address = $request->input('address');
            $order->area = $request->input('area');
            $order->zipcode = $request->input('zipcode');
        }

        // 拼团设置
        $nGroupBuy = intval($request->input('groupbuy_id'));
        if ($nGroupBuy > 0) {
            // 拼团已无效
            $group = Groupbuy::find($nGroupBuy);
            if (empty($group)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => '此拼团已无效'
                ]);
            }

            $order->groupbuy_id = $request->input('groupbuy_id');
            $order->status = Order::STATUS_GROUPBUY_WAITING;
        }
        else if ($nGroupBuy == 0) {
            // 计算到期时间
            $timeCurrent = new DateTime("now");
            $timeCurrent->add(new \DateInterval('PT' . $product->gb_timeout . 'H'));

            $aryParam = [
                'end_at' => getStringFromDateTime($timeCurrent)
            ];
            $groupBuy = Groupbuy::create($aryParam);
            $order->groupbuy_id = $groupBuy->id;

            $order->status = Order::STATUS_GROUPBUY_WAITING;
        }

        $order->save();

        // 添加订单状态历史
        $order->addStatusHistory();

        // 查看拼团状况
        $order->checkGroupBuy();

        // 减少库存
        $product->remain -= $nCount;
        $product->save();

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * 获取基础query
     * @param Request $request
     * @return Builder
     */
    private function getBaseOrderQuery(Request $request) {
        $nCustomerId = $request->input('customer_id');

        return Order::with('product')
            ->with('spec')
            ->where('customer_id', $nCustomerId)
            ->orderBy('created_at', 'desc');
    }

    /**
     * 获取我的拼团列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroupbuysApi(Request $request) {
        $query = $this->getBaseOrderQuery($request);

        $orders = $query->whereNotNull('groupbuy_id')
            ->get();

        $result = [];
        foreach ($orders as $order) {
            $orderInfo = $this->getOrderInfoSimple($order);

            $orderInfo['groupbuy'] = [
                'persons' => $order->groupBuy->getPeopleCount(),
                'remain_time' => $order->groupBuy->getRemainTime(),
            ];

            // 添加拼团信息
            $result[] = $orderInfo;
        }

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * 设置订单信息
     * @param Order $order
     * @return array
     */
    private function getOrderInfoSimple(Order $order) {
        $orderInfo = [];

        // 普通价格或拼团价格？
        $dPrice = $order->product->price;
        if (!empty($order->groupbuy_id)) {
            $dPrice = $order->product->gb_price;
        }

        $orderInfo['id'] = $order->id;
        $orderInfo['status_val'] = $order->status;
        $orderInfo['status'] = Order::getStatusName($order->status, $order->channel);
        $orderInfo['product_image'] = $order->product->getThumbnailUrl();
        $orderInfo['product_name'] = $order->product->name;
        $orderInfo['product_price'] = $dPrice;
        $orderInfo['deliver_cost'] = $order->product->deliver_cost;
        $orderInfo['count'] = $order->count;
        $orderInfo['is_groupbuy'] = !empty($order->groupbuy_id);
        $orderInfo['spec'] = $order->spec->name;
        $orderInfo['price'] = $order->price;
        $orderInfo['created_at'] = getStringFromDateTime($order->created_at);
        $orderInfo['channel'] = $order->channel;
        if ($order->store) {
            $orderInfo['store_name'] = $order->store->name;
        }

        return $orderInfo;
    }

    /**
     * 获取快递订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExpressesApi(Request $request) {
        return $this->getOrdersByDeliverApi($request, Order::DELIVER_EXPRESS);
    }

    /**
     * 获取自提订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSelfsApi(Request $request) {
        return $this->getOrdersByDeliverApi($request, Order::DELIVER_SELF);
    }

    /**
     * 获取订单列表
     * @param Request $request
     * @param $deliveryMode
     * @return \Illuminate\Http\JsonResponse
     */
    private function getOrdersByDeliverApi(Request $request, $deliveryMode) {
        $query = $this->getBaseOrderQuery($request);

        $orders = $query->where('status', '>', Order::STATUS_GROUPBUY_WAITING)
            ->where('channel', $deliveryMode)
            ->get();

        $result = [];
        foreach ($orders as $order) {
            $orderInfo = $this->getOrderInfoSimple($order);

            // 添加拼团信息
            $result[] = $orderInfo;
        }

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * 获取订单详情
     * @param $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderDetailApi($orderId) {
        $order = Order::with('product')
            ->with('spec')
            ->with('store')
            ->find($orderId);

        $result = $this->getOrderInfoSimple($order);

        // 买家留言
        $result['desc'] = $order->desc;

        // 配送信息
        $result['address'] = $order->address;
        $result['area'] = $order->area;
        $result['zipcode'] = $order->zipcode;
        $result['name'] = $order->name;
        $result['phone'] = $order->phone;
        $result['store'] = $order->store;
        $result['deliver_code'] = getEmptyString($order->deliver_code);
        $result['deliver_cost'] = $order->product->deliver_cost;

        // 拼团
        if (!empty($order->groupBuy)) {
            $result['groupbuy_persons'] = $order->groupBuy->getPeopleCount();
        }

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * 确认接收API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveProductApi(Request $request) {
        $nOrderId = $request->input('order_id');
        $order = Order::find($nOrderId);

        $order->status = Order::STATUS_RECEIVED;
        $order->save();

        // 添加订单状态历史
        $order->addStatusHistory();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
