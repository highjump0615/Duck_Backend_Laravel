<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Store;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public $menu = 'stat';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    /**
     * 打开统计页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $queryOrder = Order::query();

        // 获取参数
        $nProductId = $request->input('product');
        if (!empty($nProductId)) {
            $queryOrder->where('product_id', $nProductId);
        }

        $strDateStart = $request->input('start_date');
        if (!empty($strDateStart)) {
            $queryOrder->whereDate('created_at', '>=', $strDateStart);
        }

        $strDateEnd = $request->input('end_date');
        if (!empty($strDateEnd)) {
            $queryOrder->whereDate('created_at', '<=', $strDateStart);
        }

        $nStoreIds = array();
        if ($request->has('store')) {
            $nStoreIds = $request->input('store');
            $queryOrder->whereIn('store_id', $nStoreIds);
        }
        $nChannelId = $request->input('channel');
        if ($nChannelId != null && $nChannelId == 0 || $nChannelId == 1) {
            $queryOrder->where('channel', $nChannelId);
        }

        // 获取所有商品
        $products = Product::get(['id', 'name']);

        // 获取所有门店
        $stores = Store::get(['id', 'name']);

        //
        // 获取统计数据
        //
        $stats = array();

        // 销售数量
        $productCount = $queryOrder->sum('count');
        $stats[] = $productCount;

        // 金额
        $productPrice = $queryOrder->sum('price');
        $stats[] = $productPrice;

         // 订单数
        $orderCount = $queryOrder->count();
        $stats[] = $orderCount;

        // 退货量
        $refundCount = $queryOrder->where('status', Order::STATUS_REFUNDED)->sum('count');
        $stats[] = $refundCount;

        return view('stat.index', array_merge($this->viewBaseParams, [
            'page'          => $this->menu . '.data',

            'product'       => $nProductId,
            'start_date'    => $strDateStart,
            'end_date'      => $strDateEnd,
            'store'         => $nStoreIds,
            'channel'       => $nChannelId,

            'products'      => $products,
            'stores'        => $stores,

            'stat'          => $stats
        ]));
    }
}