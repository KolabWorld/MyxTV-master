<?php
namespace App\Lib\Validation;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Models\StaticContent as ModelsStaticContent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Validator as ValidationValidator;

class StaticContent {
    
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
                'regex:/^([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],

            "page_type" => [
                'required',
                'string',
                function($attribute,$value,$fail){
                  $staticData = ModelsStaticContent::where('page_type', $this->request->page_type)->first();
                    if($staticData){
                      $fail(ucwords($value).' page  has already been selected '.$this->request->page_type);
                    }
                }
            ],
            
            'status' => [
                'required',
                'string',
                'max:99'
            ],

            'description' => [
                'required',
                'max:9900'
            ],
            
        ]);

        return $validator;
    }

   

}