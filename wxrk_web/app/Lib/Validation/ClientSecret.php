<?php
namespace App\Lib\Validation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;
use App\Helpers\ConstantHelper;

class ClientSecret{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'payment_channel_id' => [
                'required', 
                'numeric',
                Rule::exists('payment_channels', 'id')
            ],
            'client_id' => [
                'required',
                'max:255',
                Rule::unique('payment_client_secrets', 'client_id')
            ],
            'client_secret' => [
                'required',
                'max:255',
                Rule::unique('payment_client_secrets', 'client_secret')
            ],
        ]);
      
        return $validator;
    }
}