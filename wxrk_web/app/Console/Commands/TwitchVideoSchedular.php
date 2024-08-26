<?php
namespace App\Console\Commands;

use App\Models\MailBox;
use App\Models\TwitchVideo;

use App\Helpers\GeneralHelper;

use romanzipp\Twitch\Twitch;
use Illuminate\Console\Command;
use App\Services\LoggerFactory;
use App\Services\Mailers\Mailer;
use romanzipp\Twitch\Enums\GrantType;

class TwitchVideoSchedular extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:twitch-video-schedular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store Twitch Videos';
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
        $this->log = $logFactory->setPath('logs/twitch-videos')->createLogger('twitch-videos-cron');
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->log->info('cron:twitch-video-schedular || cron started..');
        $this->data();
        // $this->insert();
        $this->log->info('cron:twitch-video-schedular || cron ends..');
    }

    public function data(){
        
        try{
            $response = $this->getVideos();
            $resp = json_decode($response);
            $i = 0;
            foreach($resp as $row) {
                $i++;
                $this->cursor = (($resp->pagination) && ($resp->pagination->cursor)) ? $resp->pagination->cursor : '';

                foreach($resp->data as $row) {
                    $this->insert($row);
                }
            }
        } catch(Exception $e){
            dd($e);
        }
    }

    public function getVideos(){
        $tokenData = $this->generateToken();
        $accessToken = "Bearer ".$tokenData->access_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.twitch.tv/helix/videos?user_id=506692386&first=100&cursor='.$this->cursor,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$accessToken,
                'Client-Id: pdagkrzxftdgbgz43ooh1xgn61qn4z'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function generateToken(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://id.twitch.tv/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('client_id' => 'pdagkrzxftdgbgz43ooh1xgn61qn4z','client_secret' => 'md36mmi0ejslqaqit4mndyubbukhm1','grant_type' => 'client_credentials'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $resp = json_decode($response);
        return $resp;
    }

    public function insert($response){
        $twitchVideo = TwitchVideo::where('twitch_id', $response->id)->first();
        if(!$twitchVideo){
            $twitchVideo = new TwitchVideo();
            echo (++$this->c) . '-N-';
        }
        else {
            echo $response->id . '-F-';
        }
        $twitchVideo->twitch_id = isset($response->id) ? $response->id : '';
        $twitchVideo->stream_id = isset($response->stream_id) ? $response->stream_id : '';
        $twitchVideo->user_id = isset($response->user_id) ? $response->user_id : '';
        $twitchVideo->user_login = isset($response->user_login) ? $response->user_login : '';
        $twitchVideo->user_name = isset($response->user_name) ? $response->user_name : '';
        $twitchVideo->title = isset($response->title) ? $response->title : '';
        // $twitchVideo->description = isset($response->description) ? $response->description : '';
        $twitchVideo->description = "";
        $twitchVideo->url = isset($response->url) ? $response->url : '';
        $twitchVideo->thumbnail_url = isset($response->thumbnail_url) ? $response->thumbnail_url : '';
        $twitchVideo->viewable = isset($response->viewable) ? $response->viewable : '';
        $twitchVideo->view_count = isset($response->view_count) ? $response->view_count : '';
        $twitchVideo->language = isset($response->language) ? $response->language : '';
        $twitchVideo->type = isset($response->type) ? $response->type : '';
        $twitchVideo->duration = isset($response->duration) ? $response->duration : '';
        $twitchVideo->muted_segments = isset($response->muted_segments) ? $response->muted_segments : '';
        $twitchVideo->video_created_at = isset($response->created_at) ? date('Y-m-d H:i:s', strtotime($response->created_at)) : '';
        $twitchVideo->video_published_at = isset($response->published_at) ? date('Y-m-d H:i:s', strtotime($response->published_at)) : '';
        $twitchVideo->status = 'active';
        $twitchVideo->save();
    }
}
