<?php namespace App\Http\Controllers\Admin\Api;

use Session;

use App\Models\ConfigServiceOption;
use App\Models\ConfigServiceOptionPrice;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Http\Controllers\AdminController;

class ServiceOptionController extends AdminController {
    public function __construct(){
        parent::__construct();
    }

    public function configServiceOptions($configServiceId)
    {
        $auth = \Auth::user();
        $status = Session::get('status');
        $serviceOptions = ConfigServiceOption::where('config_service_id', '=', $configServiceId)
            ->orderBy('id','ASC')
            ->get();

        return $serviceOptions;
    }

    public function addConfigServiceOption(Request $request) {
        
        $auth = \Auth::user();
		
        $serviceOption = new ConfigServiceOption();
        $serviceOption->config_service_id = $request->config_service_id;
        $serviceOption->name = $request->name;
        $serviceOption->indexing = $request->indexing;
        $serviceOption->created_by = $auth->id;
        $serviceOption->save();

        return $serviceOption;
    }

    public function deleteConfigServiceOption($configServiceId, $id) {
        $serviceOption = ConfigServiceOption::where('id', $id)
            ->where('config_service_id', $configServiceId)
            ->first();

        $serviceOption->delete();
        
		return ['success' => true];
	}
   
}
        
