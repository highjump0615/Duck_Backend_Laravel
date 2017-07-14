<?php

namespace App\Http\Controllers;

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
        return view('order.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
        ]));
    }

    /**
     * 打开订单详情页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrder(Request $request, $id) {
        return view('order.detail', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
        ]));
    }
}
