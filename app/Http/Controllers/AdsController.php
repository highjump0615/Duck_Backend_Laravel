<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use App\Product;

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
        $ads = Ad::all();

        return view('ads.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
            'ads' => $ads,
        ]));
    }

    /**
     * 打开添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdd() {
        $products = Product::all();
        return view('ads.detail', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
            'products'=>$products,
        ]));
    }

    /**
     * 打开详情页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetail(Request $request, $id) {
        $products = Product::all();
        $ad = Ad::find($id);
        return view('ads.detail', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
            'ad' => $ad,
            'products' => $products,
        ]));
    }

    public function saveAd(Request $request) {
        if($request->has('ad_id'))
        {
            $ad = Ad::find($request->input('ad_id'));
        } else {
            $ad = new Ad;
        }

        $ad->product_id = $request->input('product_id');
        $ad->start_at = $request->input('start_at');
        $ad->end_at = $request->input('end_at');

        $ad->save();

        if($request->hasFile('image')) {
            $file_name = 'ads_'.$ad->id.
                $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(
                base_path() . '/public/attachments/', $file_name
            );

            $ad->image_url = './attachments/' . $file_name;

            $ad->save();
        }

        return redirect()->to(url('/ads'));
    }

    public function deleteAd(Request $request) {
        if($request->has('ad_id')) {
            $aid = $request->input('ad_id');
            $ad = Ad::find($aid);

            $ad->delete();
        } else {
            abort(404);
        }
    }
}
