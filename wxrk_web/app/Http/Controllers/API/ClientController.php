<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\ApiGenericException;

use App\Models\Clients;
use App\Models\ClientAddress;

/**
 * Handling all requests related to GTM tracking
 */
class ClientController extends Controller
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
    public function addresses($id)
    {
        return ClientAddress::where('client_id', $id)->get();
    }  
}
