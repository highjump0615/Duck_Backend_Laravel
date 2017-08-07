<?php

namespace App\Console\Commands;

use App\Groupbuy;
use App\Http\Controllers\NotificationController;
use App\Order;
use App\Product;
use DateTime;
use Illuminate\Console\Command;

class GroupbuyTimeoutCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groupbuy:timeout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes orders timed out';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        // 查询所有拼团并删除已到期的
        //
        $dateNow = new DateTime("now");

        $orders = Order::with('product')
            ->where('status', Order::STATUS_GROUPBUY_WAITING)
            ->whereHas('groupbuy', function ($query) use ($dateNow) {
                $query->where('end_at', '<=', $dateNow);
            })
            ->get();

        if ($orders->count() > 0) {
            $nctrl = new NotificationController();
            $strToken = $nctrl->getAccessToken();

            foreach ($orders as $o) {
                // 恢复商品数量
                $o->product->remain += $o->count;
                $o->product->save();

                // 状态设置为失败
                $o->status = Order::STATUS_GROUPBUY_CANCELLED;
                $o->save();
                $o->addStatusHistory();

                // 自动退款
                $o->refundOrder();

                //
                // 推送消息，拼团失败
                //
                $params = array();
                $params["keyword1"] = [
                    "value" => $o->product->name,
                ];
                $params["keyword2"] = [
                    "value" => $o->price,
                ];
                $params["keyword3"] = [
                    "value" => "指定时间内凑不到人数",
                ];
                $params["keyword4"] = [
                    "value" => $o->number,
                ];

                $nctrl->sendPushNotification($strToken, [
                    "touser" => $o->customer->wechat_id,
                    "template_id" => "QPt8N12F3q-ndJITL0rED4jJ_5EgBKneO7wcmQPjM1c",
                    "form_id" => $o->formid_group,
                    "data" => $params,
                ]);

            }
        }

        // 删除过期的 groupbuy
        Groupbuy::where('end_at', '<=', $dateNow)->delete();

        $this->info("Giveup Cron is working: " . getStringFromDateTime($dateNow));

        return;
    }
}
