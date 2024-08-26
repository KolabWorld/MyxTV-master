<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\ApiGenericException;

use App\Models\GstRates;
use App\Models\GstRates;

/**
 * Handling all requests related to GTM tracking
 */
class GstController extends Controller
{
    
    public function __construct(Request $request)
    {
        // 
    }

    /**
     * store data in db for gtm tracking details
     * 
     * @param $request Request
     */
    public function data()
    {
        return GstRates::get();
    }  
}
