<?php

namespace App\Http\Controllers;

use App\Groupbuy;
use App\Order;
use App\Product;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $orders = Order::all();

        return view('order.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
            'orders'=>$orders,
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
        }
        
        $order->save();

        return redirect()->to(url('/order')."/detail/".$id);
    }

    /**
     * 下单API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeOrderApi(Request $request) {
        $nProductId = $request->input('product_id');
        $product = Product::find($nProductId);

        // 获取参数
        $aryParam = [
            'customer_id'       => $request->input('customer_id'),
            'product_id'        => $nProductId,
            'count'             => $request->input('count'),
            'name'              => $request->input('name'),
            'phone'             => $request->input('phone'),
            'spec_id'           => $request->input('spec_id'),
            'channel'           => $request->input('channel'),
            'desc'              => $request->input('desc'),
            'price'             => $request->input('price'),
            'pay_status'        => Order::STATUS_PAY_PAID,
            'status'            => Order::STATUS_INIT,
        ];

        $order = Order::create($aryParam);

        if ($request->has('store_id')) {
            $order->store_id = $request->input('store_id');
        }
        if ($request->has('address')) {
            $order->address = $request->input('address');
        }

        // 拼团设置
        $nGroupBuy = intval($request->input('groupbuy_id'));
        if ($nGroupBuy > 0) {
            $order->groupbuy_id = $request->input('address');
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

        return response()->json([
            'status' => 'success',
        ]);
    }
}
