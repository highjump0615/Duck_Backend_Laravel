<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use Illuminate\Support\Facades\DB;

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
        $stores = Store::all();
        return view('store.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',
            'stores' => $stores,
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
        $s = Store::find($id);
        return view('store.detail', [
            'store' => $s,
        ]);
    }

    public function deleteStore(Request $request) {
        $store_id = $request->input('store_id');
        $store = Store::find($store_id);

        $store->delete();
    }

    public function saveStore(Request $request) {
        if($request->has('store_id')) {
            $store_id = $request->input('store_id');
            $store = Store::find($store_id);
        } else {
            $store = new Store;
        }

        $store->name = $request->input('name');
        $store->address = $request->input('address');
        $store->phone = $request->input('phone');
        $store->longitude = $request->input('longitude');
        $store->latitude = $request->input('latitude');

        $store->save();
    }

    /**
     * 获取门店API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStoresApi(Request $request) {
        $circle_radius = 3959;

        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        if (!empty($lat) && $lat != 'undefined' &&
            !empty($lng) && $lng != 'undefined') {
            $stores = DB::select(
                "SELECT * FROM
                    (SELECT *, (" . $circle_radius . " * acos(cos(radians(" . $lat . ")) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(" . $lng . ")) +
                    sin(radians(" . $lat . ")) * sin(radians(latitude))))
                    AS distance
                    FROM store) AS distances
                ORDER BY distance;
            ");
        }
        else {
            $stores = Store::get();
        }

        return response()->json([
            'status' => 'success',
            'result' => $stores,
        ]);
    }
}
