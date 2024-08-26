<?php
namespace App\Http\Controllers\API;

use View;
use Auth;
use Session;
use Carbon\Carbon;

use App\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\EquipmentDetail;
use App\Models\EquipmentDetailLog;
use App\Models\EquipmentTypeMaster;
use App\Models\ManufacturerMaster;
use App\Models\ThirdPartyCompanyMaster;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Helpers\MenuHelper;
use App\Helpers\ConstantHelper;
use App\Exceptions\UserNotFound;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiGenericException;
use App\Notifications\CommonNotification;
use App\Lib\Validation\Admin as AccountValidator;
use Illuminate\Validation\ValidationException;
use \Laravel\Passport\Http\Controllers\AccessTokenController;

class UserController extends Controller
{

    const QUEUE_NAME = 'API';

    public function __construct()
    {
        parent::__construct();
    }

    public function profile()
	{
		$user = \Auth::user();

        $user->load([
            'roles'
        ]);
		
        $data = array(
            'user' => $user,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
	}

    public function updateAccount(Request $request)
	{
		$user = \Auth::user();
        
		$validator = (new AccountValidator($request))->updateUserAccount();
		if($validator->fails()){
			throw new ValidationException($validator);
		}

        $data = $request->only(['name','date_of_birth','mobile','email']);
		$user->fill($data);
        $user->is_new_user = $user->name ? 0 : 1;
		$user->update();

		if ($request->hasFile('profile_pic')) {
            $user->addMediaFromRequest('profile_pic')->toMediaCollection('profile_pic');
        }

        $user->load([
            'roles'
        ]);
        
        $data = array(
            'user' => $user,
        );

        return array(
			'message' => __('message.updated_successfully', ['static' => __('static.profile')]),
			'data' => $data,
		);
	}

    public function updatePassword(Request $request)
	{
		$auth = \Auth::user();
		$user = Admin::find($request->user_id);
		$validator = (new AccountValidator($request))->userChangePassword();

		if($validator->fails()){
			throw new ValidationException($validator);
		}

		if($user){
			$user->password = $request->new_password;
			$user->save();
            
            $user->load([
                'roles'
            ]);

			$data = array(
                'user' => $user,
            );
    
            return array(
                'message' => __('message.updated_successfully', ['static' => __('static.password')]),
                'data' => $data,
            );
		}
		else{
            return array(
                'message' => __('message.something_went_wrong'),
                'data' => null,
            );
		}
	}
}