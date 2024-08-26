<?php
namespace App\Lib\Validation\Admin;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

class GiftCardValidation {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function updateAdd() : ValidationValidator
    {
        
        

        $validator = Validator::make($this->request->all(),[
            'title' => [
                'required',
                'string',
                'max:190'
            ],
            'short_description' => [
                'required',
                'string',
            ],
            'price.*' => [
                'required',
                'integer',
                'distinct',
            ], 
            'status' => [
                'required'
            ], 
            'validity' => [
                'required'
            ], 
            'custom_value'=>[
                'required'
            ],
            'featured_image' => [
                "nullable", "file",
                "max:3000"
            ],
            

            
             
        ]);

        return $validator;
    }



    public function storeGiftCardsData() : ValidationValidator 
    {

        $validator = Validator::make($this->request->all(),[
            'amount' => [
                'required',
                'integer'
            ],
           
            'email' => [
                'required',
                'string',
                'email'
            ],
        ]);

        return $validator;

    }

    public function checkoutbillingAddress() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[      
            'billing_name' => ['required','string','max:99'],
            'billing_email' => [
                'required',
                'string',
                'email',
                'max:99'
            ],
            'billing_mobile' => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
            ],
            'billing_address_line_1' => [
                'required',
                'max:180'
            ],
            'billing_address_line_2' => [
                'nullable',
                'max:180'
            ],
            'billing_country_id' => [
                'required',
            ],
            'billing_city' => [
                'required',  
            ],
            'billing_postal_code' => [
                'required',
            ],
            'amount' => [
                'required',
                'integer',
            ],
        ]);
        return $validator;
    }    

}