<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatController extends Controller
{
    public $menu = 'stat';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    public function index() {
        return view('stat.index', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.data',
        ]));
    }
}
