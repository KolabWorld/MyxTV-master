<?php
namespace App\Console\Commands;

use App\Models\MailBox;
use App\Models\PoolMaster;
use App\Models\DayWiseSummary;
use App\Models\DayWisePoolMaster;

use App\Helpers\GeneralHelper;

use Illuminate\Console\Command;
use App\Services\LoggerFactory;
use App\Services\Mailers\Mailer;
use App\User;
use romanzipp\Twitch\Enums\GrantType;

class DayWisePoolMasterSchedular extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:pool-master-schedular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Day Wise Pool Master';
    public $cursor = '';

    private $c;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LoggerFactory $logFactory)
    {
        parent::__construct();
        $this->log = $logFactory->setPath('logs/pool-master')->createLogger('pool-master-cron');
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->log->info('cron:pool-master-schedular || cron started..');
        $this->data();
        // $this->insert();
        $this->log->info('cron:pool-master-schedular || cron ends..');
    }

    public function data(){
        
        try{
            $lastDate = date('Y-m-d', strtotime("-1 days"));
            $poolMaster = PoolMaster::first();
            $lastDayPoolMaster = DayWisePoolMaster::whereDate('created_at', '=', $lastDate)->first();
            if(!$lastDayPoolMaster){
                $dayWisePoolMaster = new DayWisePoolMaster();
                $dayWisePoolMaster->pool_master_id = $poolMaster->id;    
                $dayWisePoolMaster->pool_balance = $poolMaster->total_supply;    
                $dayWisePoolMaster->pool_date = date('Y-m-d');  
                $dayWisePoolMaster->total_user = 100;
                $dayWisePoolMaster->save();

                $dayLimit = $dayWisePoolMaster->pool_balance*$poolMaster->daily_limit;
                $maxPerUser = $poolMaster->max_coin_per_user*$dayWisePoolMaster->total_user;
                $wxrkDistLimit = 0;
                if($dayLimit > $maxPerUser){
                    $wxrkDistLimit = $maxPerUser;
                }
                else{
                    $wxrkDistLimit = $dayLimit;
                }
                $wxrkPerUserPerDay = $wxrkDistLimit/$dayWisePoolMaster->total_user;
                $wxrkPerMin = $wxrkPerUserPerDay/(24*60);
                
                $dayWisePoolMaster->daily_limit = $dayLimit;    
                $dayWisePoolMaster->wxrk_dist_limit = $wxrkDistLimit;    
                $dayWisePoolMaster->wxrk_per_user_per_day = $wxrkPerUserPerDay;    
                $dayWisePoolMaster->wxrk_per_min = $wxrkPerMin;
                $dayWisePoolMaster->status = 'active';
                $dayWisePoolMaster->save();    
            }
            else{
                $totalUser = User::where('status', 'active')->count();
                $todaysPoolMaster = DayWisePoolMaster::whereDate('created_at', '=', date('Y-m-d'))->first();
                if($todaysPoolMaster){
                    dd('hi');
                }

                $lastDayWxrkEarned = DayWiseSummary::whereDate('created_at', '=', date('Y-m-d', strtotime("-1 day")))->sum('wxrk_earned');
                $lastDayWxrkSpent = DayWiseSummary::whereDate('created_at', '=', date('Y-m-d', strtotime("-1 day")))->sum('wxrk_spent');
                $lastDayPoolBalance = $lastDayPoolMaster->pool_balance;

                $wxrk_pool = $lastDayPoolBalance - $lastDayWxrkEarned + $lastDayWxrkSpent;


                $dayWisePoolMaster = new DayWisePoolMaster();
                $dayWisePoolMaster->pool_master_id = $poolMaster->id;    
                $dayWisePoolMaster->pool_balance = $wxrk_pool;    
                $dayWisePoolMaster->pool_date = date('Y-m-d');  
                $dayWisePoolMaster->total_user = $totalUser;
                $dayWisePoolMaster->save();

                $dayLimit = $dayWisePoolMaster->pool_balance*$poolMaster->daily_limit;
                $maxPerUser = $poolMaster->max_coin_per_user*$dayWisePoolMaster->total_user;
                $wxrkDistLimit = 0;
                if($dayLimit > $maxPerUser){
                    $wxrkDistLimit = $maxPerUser;
                }
                else{
                    $wxrkDistLimit = $dayLimit;
                }
                $wxrkPerUserPerDay = $wxrkDistLimit/$dayWisePoolMaster->total_user;
                $wxrkPerMin = $wxrkPerUserPerDay/(24*60);
                
                $dayWisePoolMaster->daily_limit = $dayLimit;    
                $dayWisePoolMaster->wxrk_dist_limit = $wxrkDistLimit;    
                $dayWisePoolMaster->wxrk_per_user_per_day = $wxrkPerUserPerDay;    
                $dayWisePoolMaster->wxrk_per_min = $wxrkPerMin;
                $dayWisePoolMaster->status = 'active';
                $dayWisePoolMaster->save();

            }
        } catch(Exception $e){
            dd($e);
        }
    }

}
