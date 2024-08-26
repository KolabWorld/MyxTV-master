<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\City;
use App\BusinessDaily;
use App\PartnerAgreements;
use Auth;
use Datatables;
use View;
use DB;
use Session;

class WorkspaceController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_workspace');
        View::share('submenu_id','submenu_index');
    }


    public function index()
    {
        return view('admin.workspace.index');
    }

    public function salon_agreements() {

        View::share('submenu_id','submenu_salon_agreements');

        return view('admin.workspace.salon_agreements');
    }

    public function businessUpdates() {
        View::share('submenu_id','submenu_workspace_business');

        $city_array = array(''=>'--Select City--');
        $cities = City::where('active', 1)->get();
        foreach($cities as $c) {
            $city_array[$c->id] = $c->name;
        }

        $salon_array = array(''=>'--Select Salon--');

        return view('admin.workspace.business_updates', array(
                    'city_array'=>$city_array,
                    'salon_array' => $salon_array));

    }

    public function postBusinessUpdates(Request $request) {

        View::share('submenu_id','submenu_workspace_business');

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $salon_id = $request->salon_id;
        $reason = trim($request->reason);

        $businessDaily = BusinessDaily::select('*');

        if($start_date && $end_date) {
            $businessDaily = $businessDaily->where('date','>=',$start_date)
                                ->where('date','<=',$end_date);
        } else {
             $businessDaily = $businessDaily->where('date','=',$start_date);
        }

        if($salon_id) {
            $businessDaily = $businessDaily->where('salon_id','=',$salon_id);
        }

        $businessDaily = $businessDaily->get();

        foreach ($businessDaily as $row) {
            
            $row->can_edit = 'y';
            $remark = 'By['.Auth::user()->name.'] at '.date('Y-m-d H:m:i').'<br/>';
            $remark .= '---------------------------------------<br/>';
            $remark .= 'Reason:'.$reason.'<br/><br/>';
            $row->remarks   = $row->remarks . $remark;
            $row->save();
        }
        if($businessDaily->count())
            $status = array(
                'code' => 'success',
                'header' => 'Success',
                'messages' => array('Daily Business Updated Successfully')
                );
        else 
            $status = array(
                'code' => 'error',
                'header' => 'Error',
                'messages' => array('No record found')
                );

        $city_array = array(''=>'--Select City--');
        $cities = City::where('active', 1)->get();
        foreach($cities as $c) {
            $city_array[$c->id] = $c->name;
        }

        $salon_array = array(''=>'--Select Salon--');

        return view('admin.workspace.business_updates', array(
                    'city_array'=>$city_array,
                    'salon_array' => $salon_array,
                    'status' => $status));

        
    }

     public function changeAgreementStatus($agreement_id,$status) {
        $agreement = PartnerAgreements::find($agreement_id);

        if($agreement && $status) {
            $agreement->status = $status;
            $agreement->updated_by = Auth::user()->id;
            $agreement->save();
        }

        $status = array('code' => 'success',
                        'header' => 'Success',
                        'messages' => 'Salon Agreement Successfully Updated'
                        );

        return response()->json($status);
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data_salon_agreements(Request $request)
    {
         
        $status = array('CREATED','SENT_FOR_REVIEW','APPROVED','REJECTED','REOPENED');

        $default = array('SENT_FOR_REVIEW');

        $filter_status = $request->input('filter_status', $default);
     
        $agreements = PartnerAgreements::select('partner_agreements.salon_id','commission_model','commission_perc','frenchise_fee','monthly_fee','effective_from','effective_to','partner_agreements.status','users.name as created_by','partner_agreements.created_at','partner_agreements.id','salons.name as salon_name')
            ->leftjoin('salons', 'salons.id', '=', 'partner_agreements.salon_id')
            ->leftjoin('users', 'users.id', '=', 'partner_agreements.created_by')
            ->whereIn('partner_agreements.status',$filter_status)
             ->get();

       
        return response()->json(array('agreements'=>$agreements,'all_status'=>$status,'filter_status'=>$filter_status));
    }


}