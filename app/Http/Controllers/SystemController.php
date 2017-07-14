<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SystemController extends Controller
{
    public $menu = 'system';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    public function index() {
        $s = Setting::first();
        if($s == null) {
            $s = new Setting;
            $s->save();
        }

        return view('system.setting', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.setting',
            'setting'=>$s,
        ]));
    }

    public function saveSetting(Request $request) {
        $s = Setting::first();
        if($s == null) {
            $s = new Setting();
        }

        $s->phone = $request->input('phone');
        $s->notice_refund = $request->input('notice_refund');
        $s->notice_groupbuy = $request->input('notice_groupbuy');

        $s->save();

        return view('system.setting', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.setting',
            'setting'=>$s,
        ]));
    }
}
