<?php
namespace App\Lib\Validation;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Models\SubscriptionPlan as ModelsSubscriptionPlan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Validator as ValidationValidator;

class SubscriptionPlan {
    
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "plan_type" => [
                'required',
                'regex:/^([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "name" => [
                'required',
                'regex:/^([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
                function($attribute, $value, $fail){
                    $existingPlan = ModelsSubscriptionPlan::where('name', $value)->where('plan_type', $this->request->plan_type)->first();
                    if($existingPlan){
                        $fail(ucwords($value).' plan has already been taken '.$this->request->plan_type);
                    }
                }
            ],
            "price" => 'required|integer|min:0|max:10000000',
            "offers_in_a_month" => 'required|integer|min:0|max:100000',
            "premium_days" => 'required|integer|min:0|max:1000',
            "description" => [
                'nullable',
                'string',
                'max:1099'
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
            "plan_type" => [
                'required',
                'regex:/^([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "name" => [
                'required',
                'regex:/^([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
                function($attribute, $value, $fail){
                    $existingPlan = ModelsSubscriptionPlan::where('name', $value)
                        ->where('plan_type', $this->request->plan_type)
                        ->where('id', '!=', $this->request->id)
                        ->first();
                    if($existingPlan){
                        $fail(ucwords($value).' plan has already been taken '.$this->request->plan_type);
                    }
                }
            ],
            "price" => 'required|integer|min:0|max:10000000',
            "offers_in_a_month" => 'required|integer|min:0|max:100000',
            "premium_days" => 'required|integer|min:0|max:1000',
            "description" => [
                'nullable',
                'string',
                'max:1099'
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