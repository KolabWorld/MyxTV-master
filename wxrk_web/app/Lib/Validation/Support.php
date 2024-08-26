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

class Support
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            "category_id" => [
                'required',
                'integer',
                'exists:support_categories,id'
            ],
            "sub_category_id" => [
                'required',
                'integer',
                'exists:support_categories,id'
            ],
            "subject" => [
                'required',
                'string',
                'max:199'
            ],
            "description" => [
                'required',
                'string',
                'max:2000'
            ],
            'status' => [
                'required',
                'string',
                'max:99'
            ],
            'attachments' => [
                'nullable',
                'array',
            ],
            'attachments.*' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024',
            ],
        ]);

        return $validator;
    }

    public function update(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            "category_id" => [
                'required',
                'integer',
                'exists:support_categories,id'
            ],
            "sub_category_id" => [
                'required',
                'integer',
                'exists:support_categories,id'
            ],
            "subject" => [
                'required',
                'string',
                'max:199'
            ],
            "description" => [
                'required',
                'string',
                'max:2000'
            ],
            'status' => [
                'required',
                'string',
                'max:99'
            ],
            'attachments' => [
                'nullable',
                'array',
            ],
            'attachments.*' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024',
            ],
        ]);

        return $validator;
    }

    public function updateAdmin(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            // "category_id" => [
            //     'required',
            //     'integer',
            //     'exists:support_categories,id'
            // ],
            // "sub_category_id" => [
            //     'required',
            //     'integer',
            //     'exists:support_categories,id'
            // ],
            // "subject" => [
            //     'required',
            //     'string',
            //     'max:199'
            // ],
            // "description" => [
            //     'required',
            //     'string',
            //     'max:2000'
            // ],
            'status' => [
                'required',
                'string',
                'max:99'
            ],
            // 'attachments' => [
            //     'nullable',
            //     'array',
            // ],
            // 'attachments.*' => [
            //     'nullable',
            //     'file',
            //     'mimes:png,jpeg,jpg',
            //     'max:1024',
            // ],
        ]);

        return $validator;
    }

    public function saveComments(): ValidationValidator
    {
        $rules = [
            "remark" => [
                'required',
                'string',
                'max:199',
            ],
            'attachment' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024',
            ],
        ];

        $validator = Validator::make($this->request->all(), $rules);

        return $validator;
    }
}
