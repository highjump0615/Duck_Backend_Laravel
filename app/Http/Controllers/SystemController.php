<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    public $menu = 'system';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    public function index() {
        return view('system.setting', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.setting',
        ]));
    }
}
