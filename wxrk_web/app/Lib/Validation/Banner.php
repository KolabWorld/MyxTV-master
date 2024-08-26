<?php

namespace App\Lib\Validation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

use App\Helpers\ConstantHelper;

class Banner
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store(): ValidationValidator
    {
        $rules = [
            'type' => [
                'nullable',
                'string',
                'max:191'
            ],
            'name' => [
                'required',
                'string',
                'max:291'
            ],
            'button_text' => [
                'nullable',
                'string',
                'max:191'
            ],
            'button_link' => [
                'nullable',
                'string',
                'max:191'
            ],
            'attachment_type' => [
                'required',
                'string',
                'max:191'
            ],
            'is_auto_play' => [
                'required_if:attachment_type,video',
                'nullable',
                'integer',
                'max:1',
                'min:0'
            ],
        ];

        if ($this->request->attachment_type == 'video') {
            $rules['image'] = [
                'required',
                'file',
                'mimes:mp4,mov,avi',
                'max:153600'
            ];
        }

        if ($this->request->attachment_type == 'image') {
            $rules['image'] = [
                'required',
                'file',
                'mimes:gif,png,jpeg,jpg',
                'max:3072'
            ];
        }

        $validator = Validator::make($this->request->all(), $rules);

        return $validator;
    }

    public function update(): ValidationValidator
    {
        $rules = [
            'type' => [
                'nullable',
                'string',
                'max:191'
            ],
            'name' => [
                'required',
                'string',
                'max:291'
            ],
            'button_text' => [
                'nullable',
                'string',
                'max:191'
            ],
            'button_link' => [
                'nullable',
                'string',
                'max:191'
            ],
            'attachment_type' => [
                'required',
                'string',
                'max:191'
            ],
            'is_auto_play' => [
                'required_if:attachment_type,video',
                'nullable',
                'integer',
                'max:1',
                'min:0'
            ],
        ];

        if ($this->request->attachment_type == 'video') {
            $rules['attachment'] = [
                'nullable',
                'file',
                'mimes:mp4,mov,avi',
                'max:153600'
            ];
        }

        if ($this->request->attachment_type == 'image') {
            $rules['attachment'] = [
                'nullable',
                'file',
                'mimes:gif,png,jpeg,jpg',
                'max:3072'
            ];
        }

        $validator = Validator::make($this->request->all(), $rules);

        return $validator;
    }
}
