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
        $strWechatId = $request->input('wechat_id');

        $customer = Customer::where('wechat_id', $strWechatId)->first();

        if (empty($customer)) {
            $customer = new Customer;
            $customer->wechat_id = $strWechatId;
        }

        $customer->name = $request->input('name');
        $customer->image_url = $request->input('photo_url');
        $customer->save();

        return response()->json([
            'status' => 'success',
            'customer_id' => $customer->id,
        ]);
    }
}
