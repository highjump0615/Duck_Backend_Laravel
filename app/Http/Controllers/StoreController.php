<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public $menu = 'store';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    /**
     * 打开门店列表页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showStores(Request $request) {
        return view('store.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
        ]));
    }

    /**
     * 打开添加页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdd(Request $request) {
        return view('store.detail');
    }

    /**
     * 打开修改页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetail(Request $request, $id) {

        return view('store.detail', [

        ]);
    }
}
