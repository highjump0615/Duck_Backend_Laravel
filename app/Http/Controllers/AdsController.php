<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdsController extends Controller
{
    public $menu = 'ads';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    /**
     * 打开宣传列表页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAds() {
        return view('ads.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
        ]));
    }

    /**
     * 打开添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdd() {
        return view('ads.detail', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
        ]));
    }

    public function showDetail(Request $request, $id) {
        return view('ads.detail', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
        ]));
    }
}
