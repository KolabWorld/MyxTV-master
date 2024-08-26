<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Models\TwitchVideo;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiGenericException;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;

class TwitchVideoController extends Controller
{

    const QUEUE_NAME = 'API';

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = \Auth::user();

        $twitchVideos = TwitchVideo::latest();

        if ($request->search) {
            $keyword = $request->search;
            $twitchVideos->where(function ($q) use ($keyword) {
                $q->where('twitch_id', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('stream_id', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('type', 'LIKE', '%' . $keyword . '%');
            });
        }

        $twitchVideos = $twitchVideos->get();

        $data = array(
            'twitch-videos' => $twitchVideos,
        );

        return array(
            'message' => __('message.fetch_records'),
            'data' => $data,
        );
    }
}
