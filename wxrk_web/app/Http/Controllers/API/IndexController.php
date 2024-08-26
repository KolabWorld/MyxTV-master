<?php

namespace App\Http\Controllers\API;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\ApiGenericException;

use App\User;
use App\Models\Contacts;
use App\Models\Groups;

/**
 * Handling all requests related to GTM tracking
 */
class IndexController extends Controller
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
    public function index()
    {
        return Auth::guard('api')->user();
    }  

    public function userList()
    {
        $user = Auth::guard('api')->user();
        return User::where('id', '<>', $user->id)->orderBy('name')->get();
    }
    
    public function managersList()
    {
        $user = Auth::guard('api')->user();
        return User::where('id', '<>', $user->id)
            ->whereHas('roles', function($q){
                $q->where('name', '=', 'manager');
            })
            ->orderBy('name')->get();
    }

    public function groupContacts($name) {
        
        $contacts = Contacts::select(
            'contacts.*'
        )
        ->leftJoin('group_contacts', 'group_.contact_id', '=', 'contacts.id')
        ->leftJoin('groups', 'groups.id', '=', 'group_contacts.group_id')
        ->where('groups.name', 'LIKE', $name)
        ->orderBy('contacts.name')
        ->get();
        
        return $contacts;
    }
}
