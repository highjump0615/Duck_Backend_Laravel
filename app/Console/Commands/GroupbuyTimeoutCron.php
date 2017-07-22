<?php

namespace App\Console\Commands;

use App\Groupbuy;
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
            ->whereHas('groupbuy', function ($query) use ($dateNow) {
                $query->where('end_at', '<=', $dateNow);
            })
            ->get();

        foreach ($orders as $o) {
            // 恢复商品数量
            $o->product->remain += $o->count;
            $o->product->save();

            // 状态设置为失败
            $o->status = Order::STATUS_GROUPBUY_CANCELLED;
            $o->addStatusHistory();
            $o->save();
        }

        // 删除过期的 groupbuy
        Groupbuy::where('end_at', '<=', $dateNow)->delete();

        $this->info("Giveup Cron is working: " . getStringFromDateTime($dateNow));

        return;
    }
}
