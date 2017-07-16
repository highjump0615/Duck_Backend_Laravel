<?php

namespace App\Console\Commands;

use App\Groupbuy;
use App\Order;
use DateTime;
use function foo\func;
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

        Order::whereHas('groupbuy', function ($query) use ($dateNow) {
            $query->whereDate('end_at', '>', $dateNow);
        })->delete();

        Groupbuy::whereDate('end_at', '>', $dateNow)->delete();

        $this->info("Giveup Cron is working: " . getStringFromDateTime($dateNow));

        return;
    }
}
