<?php

namespace App\Http\Controllers;

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
        // 获取参数
        $nStoreIds = array();
        $nProductId = $request->input('product');
        $strDateStart = $request->input('start_date');
        $strDateEnd = $request->input('end_date');
        if ($request->has('store')) {
            $nStoreIds = $request->input('store');
        }
        $nChannelId = $request->input('channel');

        // 获取所有商品
        $products = Product::get(['id', 'name']);

        // 获取所有门店
        $stores = Store::get(['id', 'name']);

        return view('stat.index', array_merge($this->viewBaseParams, [
            'page'          => $this->menu . '.data',

            'product'       => $nProductId,
            'start_date'    => $strDateStart,
            'end_date'      => $strDateEnd,
            'store'         => $nStoreIds,
            'channel'       => $nChannelId,

            'products'      => $products,
            'stores'        => $stores,
        ]));
    }
}
