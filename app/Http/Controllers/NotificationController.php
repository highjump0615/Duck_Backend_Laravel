<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * 获取推送access token
     * @return string
     */
    public function getAccessToken() {

        $client = new Client();
        $strUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential"
            . "&appid=" . env('WECHAT_APPID')
            . "&secret=" . env('WECHAT_SECRET');

        $res = $client->request('GET', $strUrl)->getBody();
        $jsonRes = json_decode($res);

        Log::info("access token result: " . $res);

        return empty($jsonRes->access_token) ? "" : $jsonRes->access_token;
    }

    /**
     * 推送消息
     * @param $token
     * @param $data
     * @return bool
     */
    public function sendPushNotification($token, $data) {
        if (empty($token)) {
            return false;
        }

        $client = new Client();
        $strUrl = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $token;

//        $jsonPost = response()->json($data);
//
//        $request = $client->post($strUrl, array("content-type" => "application/json"), array());
//        $request->setBody($data);
//        $res = $request->send();

        $res = $client->request('POST', $strUrl, ['json' => $data])->getBody();

        $jsonRes = json_decode($res);

        Log::info("sendPushNotification result: " . $res);

        return true;
    }

    //发送请求
    private function https_request($url,$data,$type) {
        if($type=='json') {
            //json
            $_POST = json_decode(file_get_contents('php://input'), TRUE);
            $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
            $data = json_encode($data);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }
}
