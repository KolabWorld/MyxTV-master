<?php

namespace App\Http\Controllers\Frontend\Master;

use App\Models\TokenSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

class TokenSettingController extends AdminController
{
    public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request)
    {
        $user = \Auth::user();

        $tokenSettings = TokenSetting::latest();
        
        $tokenSettings = $tokenSettings->paginate(10);

        return view('frontend.master.token-setting.index',array(
              'tab' =>'token-setting',
              'tokenSettings' => $tokenSettings,
              'user'=>$user,
        ));
    }
   

    public function create(Request $request)
    {
        $user = \Auth::user();

        if($tokenSetting = TokenSetting::latest()->first()){
			return redirect('/token-setting/'.$tokenSetting->id.'/edit');
		}

        $tokenSetting = new TokenSetting();
        $action = '/token-setting/create';

        return view('frontend.master.token-setting.create_edit',array(
            'tab' =>'token-setting',
            'tokenSetting'=> $tokenSetting,
            'action' =>  $action,
            'request'=>$request,
        ));
    }
   
    public function store(Request $request)
    {   
        $user = \Auth::user();
        //dd($request->all());
        $tokenSetting = new TokenSetting();
        $tokenSetting->fill($request->all());
        $tokenSetting->save();
        
        return [
          'message' => 'Record added successfully!'
        ];
    }

    public function edit($id)
    {
        $user = \Auth::user();

        $tokenSetting = TokenSetting::find($id);

        $action = '/token-setting/'.$id.'/edit';

        return view('frontend.master.token-setting.create_edit',array(
                'tab' =>'token-setting',
                'tokenSetting' => $tokenSetting,
                'action' => $action,
                'user' =>$user,
        ));
    }

    public function update(Request $request, $id)
    {
        $user = \Auth::user();

        $tokenSetting = TokenSetting::find($id);
        $tokenSetting->fill($request->all());
        $tokenSetting->save();

        return [
            'message' => 'Record Updated successfully!'
        ];
    }

    public function destroy($id){
		$user = \Auth::user();

		$tokenSetting = TokenSetting::find($id);
		if(count($tokenSetting->events) > 0){
			return [
				'message' => 'Please remove existing mappings to delete this record.',
			];
		}
		else{
			$tokenSetting->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}
}
