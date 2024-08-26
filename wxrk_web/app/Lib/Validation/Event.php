<?php
namespace App\Lib\Validation;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Validator as ValidationValidator;

class Event {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "name" => [
                'required',
                'regex:/^[A-Z]([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "event_host" =>[
                'required',
                'string',
                'max:199',

            ],
            "event_type_id" => [
                'required',
                'integer',
                'exists:event_types,id'
            ],
            'countries' => [
                'required',
                'array',
            ],
            'countries.*' => [
                'required',
                'exists:countries,id',
            ],
            "venue" => [
                'required',
                'string',
                'max:199',
            ],
            "description" => [
                'nullable',
                'string',
                'max:599'
            ],
            "heghlights" => [
                'nullable',
                'string',
                'max:599'
            ],
            "start_date_time" => 'required|after_or_equal:today',
            "end_date_time" => 'required|after_or_equal:start_date_time',
            "company_name" => [
                'required',
                'string',
                'max:191',
            ],
            "about_the_company" => [
                'nullable',
                'string',
                'max:599'
            ],
            'company_logo' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'thumbnail_image' => [
                'required',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'banners.*' => [
                'required',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'sponsers.*' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'status' => [
                'required',
                'string',
                'max:99'
            ],
            
        ]);

        return $validator;
    }

    public function update() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "name" => [
                'required',
                'regex:/^[A-Z]([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "event_host" =>[
                'required',
                'string',
                'max:199',
            ],
            "event_type_id" => [
                'required',
                'integer',
                'exists:event_types,id'
            ],
            "venue" => [
                'required',
                'string',
                'max:199',
            ],
            "description" => [
                'nullable',
                'string',
                'max:599'
            ],
            "highlights" => [
                'nullable',
                'string',
                'max:599'
            ],
            "start_date_time" => 'required|after_or_equal:today',
            "end_date_time" => 'required|after_or_equal:start_date_time',
            "company_name" => [
                'required',
                'string',
                'max:191',
            ],
            "about_the_company" => [
                'nullable',
                'string',
                'max:599'
            ],
            'company_logo' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'thumbnail_image' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'banners.*' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'sponsers.*' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'status' => [
                'required',
                'string',
                'max:99'
            ],
        ]);

        return $validator;
    }

}