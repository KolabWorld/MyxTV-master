<?php namespace App\Http\Controllers\Admin\Master;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\SocialMedia;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;

class SocialMediaController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_master');
        View::share('submenu_id','submenu_social_media');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.master.social-media.index',  array('status' => $status));
    }

    public function create()
    {
        $socialMedia = new SocialMedia;

        return view('admin.master.social-media.create_edit',
            array(
                'socialMedia' => $socialMedia
            )
        );
    }

    public function store(Request $request) {
        $auth = \Auth::user();
		$status = array();
		$validator = (new Validator($request))->storeSocialMedia();

		if($validator->fails()){
			throw new ValidationException($validator);
		}

        $socialMedia = new SocialMedia();
        $input = $request->all();
        $socialMedia->fill($input);
        $socialMedia->save();

        if($request->hasFile('image')){
            $socialMedia->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Social Media successfully created')
                );

        return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function edit($id)
    {
        $status = Session::get('status');
        $socialMedia = SocialMedia::find($id);

        return view('admin.master.social-media.create_edit',
            array(
                'socialMedia' => $socialMedia,
                'status' => $status
            )
        );
    }

    public function update(Request $request, $id) {
        $auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updateSocialMedia();

		if($validator->fails()){
            throw new ValidationException($validator);
		}

        $socialMedia = SocialMedia::find($id);

        $input = $request->all();
        $socialMedia->fill($input);
        $socialMedia->save();

        if($request->hasFile('image')){
            $socialMedia->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Social Media successfully edited')
                );

            return '<script type="text/javascript">
            parent.jQuery.colorbox.close();
            </script>';
    }

    public function delete($id) {
        $socialMedia = SocialMedia::find($id);

        if($socialMedia ->delete()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Social Media successfully deleted')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested socialMedia ')
            );
        }

        return redirect('admin/master/social-links')->with('status', $status);
    }

    public function restore($id) {
        $socialMedia = SocialMedia::withTrashed()->find($id);

        if($socialMedia->restore()) {
            $status = array('code' => 'success',
                'header' => 'Success',
                'messages' => array('Social Media successfully restored')
            );
        } else {
            $status = array('code' => 'danger',
                'header' => 'Error',
                'messages' => array('Something went wrong, unable to delete requested socialMedia')
            );
        }

        return redirect('admin/master/social-links')->with('status', $status);
    }

    public function data()
    {

        $socialLinks = SocialMedia::withTrashed()->select('name', 'name as image', 'icon', 'link', 'deleted_at', 'created_at',  'id');

        return Datatables::of($socialLinks)
            ->editColumn('image', function($row) {
                $icon = '';
                if($row->image){
                    $icon .= "<img src='".$row->image."' class='img-responsive img-thumbnail' alt='$row->name' style='width:50px;height:50px;' />";
                }
                else{
                    $icon .= "<img src='".asset('assets/img/defaults.png')."' class='img-responsive img-thumbnail' alt='Default Icon' style='width:50px;height:50px;' />";
                }
                return $icon;
            })
            ->editColumn('icon', function($row) {
                $facIcon = '';
                if($row->icon){
                    $facIcon .= "<i class='".$row->icon."'></i>";
                }
                else{
                    $facIcon .= "";
                }
                return $facIcon;
            })
            ->editColumn('created_at', function($row) {
                $x = "{$row->created_at}";
                return date('M d, Y h:i A',strtotime($x));
            })
            ->editColumn('deleted_at', function($row) {
				if($row->deleted_at) {
					return '<span class=\'glyphicon glyphicon-remove\'></span>';
				} else {
					return '<span class="glyphicon glyphicon-ok"></span>';
				}
			})
            ->addColumn('actions', function($row) {

                $actions = '';
                if ($row->deleted_at) {
                    $actions .= "<a href='/admin/master/social-link/$row->id/restore' class='btn btn-info btn-sm' ><span class='fa fa-refresh'></span></a>";
                }
                else {
                    $actions = "<a href='/admin/master/social-link/$row->id/edit' class='btn btn-success btn-sm iframe' ><span class='glyphicon glyphicon-pencil'></span></a>";

                    $actions .= "<a href='/admin/master/social-link/$row->id/delete' class='btn btn-danger btn-sm' ><span class='fa fa-trash'></span></a>";
                }

                return $actions;
            })
            ->rawColumns(['image', 'icon', 'deleted_at', 'actions'])
            ->removeColumn('id')
            ->make();

    }

}
