<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 添加客户API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setCustomerApi(Request $request) {
        $strLoginCode = $request->input('login_code');

        // 先获取openid
        $client = new Client();
        $strUrl = "https://api.weixin.qq.com/sns/jscode2session"
            . "?appid=" . env('WECHAT_APPID')
            . "&secret=" . env('WECHAT_SECRET')
            . "&grant_type=authorization_code"
            . "&js_code=" . $strLoginCode;

        $res = $client->request('GET', $strUrl)->getBody();
        $jsonRes = json_decode($res);

        if (empty($jsonRes->openid)) {
            // 获取不到，失败
            return response()->json([
                'status' => 'fail',
                'result' => $jsonRes
            ]);
        }

        $strWechatId = $jsonRes->openid;

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
