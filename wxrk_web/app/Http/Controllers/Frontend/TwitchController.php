<?php
namespace App\Http\Controllers\Frontend;

use DB;
use View;
use Auth;
use Session;
use stdClass;
use Datatables;
use Carbon\Carbon;
use romanzipp\Twitch\Twitch;
use romanzipp\Twitch\Enums\GrantType;

use App\User;
use App\Models\Admin;
use App\Models\UserWallet;
use App\Models\TwitchVideo;
use App\Models\DayWiseSummary;
use App\Models\WalletTransaction;
use App\Models\DayWisePoolMaster;
use App\Models\TwitchVideosStreamer;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use App\Helpers\ConstantHelper;
use App\Helpers\GeneralHelper;

class TwitchController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$twitch = new Twitch;

        $videos = array();

        $twitch->setClientId('pdagkrzxftdgbgz43ooh1xgn61qn4z');
        $twitch->setClientSecret('md36mmi0ejslqaqit4mndyubbukhm1');
        $twitch->setToken('jcpmffrp4ekmoaus0fhi1vbxd6y5ty');

        $result = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS);
        // dd($result);
        if ( ! $result->success()) {
            return;
        }

        $accessToken = $result->data()->access_token;
        $twitch->setToken($accessToken);
        // dd($accessToken);
		// Page 1
        $firstResult = $twitch->getStreams(['language' => 'de']);
        // $firstResult = $twitch->getVideos(['language' => 'de']);
        $data = array();
        foreach($firstResult->data() as $row) {

            // dd(intval($row->id));
            $videos = $twitch->getVideos([
                // 'id' => intval($row->id),
                'user_id' => '506692386', 
                // 'game_id' => $row->game_id
            ]);

            $data[] = array(
                'stream' => $row,
                'videos' => $videos
            );
        }

        return view('frontend.twitch-videos.index', array(
			'tab' =>'twitch',
            'user' => $user,
            'videos' => $videos,
            'data' => $data, 
            'firstResult' => $firstResult,
        ));
	}

    public function video($id) {
        return view('frontend.twitch-videos.video', ['id' => $id]);
    }

    public function appVideo(Request $request, $id) {
        // dd([$request->user_id, $id]);
        $twitchVideo = TwitchVideo::where('twitch_id', $id)
            ->first();
        if($twitchVideo){
            $videoStreamer = TwitchVideosStreamer::where('twitch_id', $id) 
                ->where('user_id', $request->user_id)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();
                
            if(!$videoStreamer){
                $videoStreamer = new TwitchVideosStreamer();
            }
            $videoStreamer->twitch_video_id = (isset($twitchVideo) && $twitchVideo->id) ? $twitchVideo->id : '';
            $videoStreamer->twitch_id = $id;
            $videoStreamer->user_id = $request->user_id;
            $videoStreamer->video_duration = $twitchVideo->duration;
            $videoStreamer->save();
        }

        return view('frontend.twitch-videos.app-video', 
            [
                'id' => $id,
                'user_id' => $request->user_id,
            ]
        );
    }

    public function timeCalculation(Request $request) {

        $wxrkEarned = 0;
        $wxrkSpent = 0;
        $wxrkBalance = 0;
        $dayWiseSummaryData = '';
        $totakWrxkPerUser = DayWiseSummary::where('user_id', $request->user_id)->whereDate('created_at', date('Y-m-d'))->sum('wxrk_earned');
        $totakWrxkUser = DayWiseSummary::whereDate('created_at', date('Y-m-d'))->sum('wxrk_earned');
        $dayWisePoolMaster = DayWisePoolMaster::whereDate('pool_date', date('Y-m-d'))
            ->first();
        $wxrkPerMinute = $dayWisePoolMaster ? $dayWisePoolMaster->wxrk_per_min : 1.00;
        $dayWiseSummaryData = DayWiseSummary::where('user_id', $request->user_id)
            ->whereDate('created_at', date('Y-m-d'))
            ->first();
        $userWallet = UserWallet::where('user_id', $request->user_id)
            ->first();
        $videoStreamer = TwitchVideosStreamer::where('twitch_id', $request->video_id) 
            ->where('user_id', $request->user_id)
            ->whereDate('created_at', date('Y-m-d'))
            ->first();
        
        if(!$videoStreamer){
            $data = array(
                'code' => 204,
                'status' => 'error',
                'message' => 'Something went wrong !!',
                'data' => '',
            );

            return $data;
        }

        if($totakWrxkUser > $dayWisePoolMaster->wxrk_dist_limit){
            $data = array(
                'code' => 200,
                'status' => 'success',
                'message' => 'All coin have been distributed for today',
                'data' => $totakWrxkUser,
            );
    
            return $data;

            
        }

        // dd($totakWrxkUser > $dayWisePoolMaster->wxrk_dist_limit);exit;

        if($totakWrxkPerUser > $dayWisePoolMaster->wxrk_per_user_per_day){
            $data = array(
                'code' => 200,
                'status' => 'success',
                'message' => 'Your coins have been distributed for today',
                'data' => $totakWrxkPerUser,
            );
            return $data;
        }

        $coin = $request->watch_time/60;
        $videoStreamer->watching_duration = $request->watch_time;
        $videoStreamer->coin = number_format($coin, 4);
        $videoStreamer->save();

        if(!$dayWiseSummaryData){
            $dayWiseSummaryData = new DayWiseSummary();
            $dayWiseSummaryData->user_id = $videoStreamer->user_id;
            $wxrkEarned = $coin*$wxrkPerMinute;
            $wxrkBalance = $wxrkEarned - $wxrkSpent;

            $dayWiseSummaryData->watch_time = $videoStreamer->watching_duration;
            $dayWiseSummaryData->wxrk_per_minute = $wxrkPerMinute;
            $dayWiseSummaryData->wxrk_earned = $wxrkEarned;
            $dayWiseSummaryData->wxrk_spent = $wxrkSpent;
            $dayWiseSummaryData->wxrk_balance = $wxrkBalance;
            $dayWiseSummaryData->save();
        }
        else{
            $dayWiseSummaryData->user_id = $videoStreamer->user_id;
            $dayWiseSummaryData->watch_time += $videoStreamer->watching_duration;
            
            $wxrkEarned = $dayWiseSummaryData->wxrk_earned + ($coin*$wxrkPerMinute);
            $wxrkBalance = $wxrkEarned - $wxrkSpent;
            
            $dayWiseSummaryData->wxrk_per_minute = $wxrkPerMinute;
            $dayWiseSummaryData->wxrk_earned = $wxrkEarned;
            $dayWiseSummaryData->wxrk_spent = $wxrkSpent;
            $dayWiseSummaryData->wxrk_balance = $wxrkBalance;
            $dayWiseSummaryData->save();

        }



        $previousDaySummaryData = DayWiseSummary::where('user_id', $request->user_id)
            ->where('id', '<', $dayWiseSummaryData->id)
            ->orderBy('id', 'DESC')
            ->first();
            
        if($previousDaySummaryData){
            $savedTime = strval((int)($dayWiseSummaryData->watch_time - $previousDaySummaryData->watch_time));
            $dayWiseSummaryData->time_saved = $savedTime;
            if($dayWiseSummaryData->watch_time > $previousDaySummaryData->watch_time){
                $timeSavedPercentage = ($dayWiseSummaryData->watch_time - $previousDaySummaryData->watch_time) / $dayWiseSummaryData->watch_time * 100;
                $dayWiseSummaryData->time_saved_percentage = strval((int)$timeSavedPercentage);
            }
            else{
                $timeSavedPercentage = ($previousDaySummaryData->watch_time - $dayWiseSummaryData->watch_time) / $previousDaySummaryData->watch_time * 100;
                $dayWiseSummaryData->time_saved_percentage = '-' .strval((int)$timeSavedPercentage);
            }
            $dayWiseSummaryData->save();
        }

        if(!$userWallet){
            $userWallet = new UserWallet();
            $userWallet->user_id = $dayWiseSummaryData->user_id;
            $userWallet->watch_time = $dayWiseSummaryData->watching_duration;
            $userWallet->wxrk_earned = $dayWiseSummaryData->wxrk_earned;
            $userWallet->wxrk_balance = $dayWiseSummaryData->wxrk_earned;
            $userWallet->save();
        }
        else{
            $userWallet->watch_time = $userWallet->watch_time + $videoStreamer->watching_duration;
            $userWallet->wxrk_earned = $userWallet->wxrk_earned + ($request->watch_time*$wxrkPerMinute);
            $userWallet->wxrk_balance = $userWallet->wxrk_balance + ($request->watch_time*$wxrkPerMinute);
            $userWallet->save();
        }

        $walletTransaction = new WalletTransaction();
        $walletTransaction->user_id = $videoStreamer->user_id;
        $walletTransaction->type = 'earned';
        $walletTransaction->wxrk_balance = $videoStreamer->watching_duration*$wxrkPerMinute;
        $walletTransaction->watch_time = $videoStreamer->watching_duration;
        $walletTransaction->status = "active";
        $walletTransaction->save();

        $data = array(
            'code' => 200,
            'status' => 'success',
            'message' => 'Data saved successfuly',
            'data' => $videoStreamer,
        );

        return $data;

    }
}