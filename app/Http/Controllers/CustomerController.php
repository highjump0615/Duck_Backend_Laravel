<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 添加客户API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setCustomerApi(Request $request) {
        // 获取参数
        $aryParam = [
            'wechat_id' => $request->input('wechat_id'),
            'name'      => $request->input('name'),
            'image_url' => $request->input('photo_url'),
        ];

        $customer = Customer::create($aryParam);

        return response()->json([
            'status' => 'success',
            'customer_id' => $customer->id,
        ]);
    }
}
