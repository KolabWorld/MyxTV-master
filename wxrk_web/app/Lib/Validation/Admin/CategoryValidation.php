<?php
namespace App\Lib\Validation\Admin;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

class CategoryValidation {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function storeMainCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                Rule::unique('main_categories', 'name')
                    ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('main_categories', 'alias')
                    ->whereNull('deleted_at')
            ],
            'parent_id' => [
                'nullable', 'numeric',
                Rule::exists('main_categories', 'id')
            ],
        ]);
        return $validator;
    }

    public function updateMainCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                Rule::unique('main_categories', 'name')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('main_categories', 'alias')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
            'parent_id' => [
                'nullable', 'numeric',
                Rule::exists('main_categories', 'id')
            ],
            'url' => [
                'required', 'string', 'max:99',
            ],
        ]);
        return $validator;
    }

    public function storeProductType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                Rule::unique('product_type_masters', 'name')
                    ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('product_type_masters', 'alias')
                    ->whereNull('deleted_at')
            ],
        ]);
        return $validator;
    }

    public function updateProductType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                Rule::unique('product_type_masters', 'name')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('product_type_masters', 'alias')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
        ]);
        return $validator;
    }

    public function storeSizeGuide() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'title' => [
                'required', 'string', 'max:99'
            ],
            'attachment_url' => [
                "required", "mimes:mp4,mkv,avi", "max:150000"
            ]
        ]);
        return $validator;
    }

    public function updateSizeGuide() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'title' => [
                'required', 'string', 'max:99'
            ],
            'attachment_url' => [
                "nullable", "mimes:mp4,mkv,avi", "max:150000"
            ]
        ]);
        return $validator;
    }

    public function storeProductAttribute() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required', 'string', 'max:99',
                Rule::unique('product_attributes', 'name')
                    ->whereNull('deleted_at')
            ],
            'type' => [
                'required', 'string',
                Rule::in(ConstantHelper::OPTION_TYPE)
            ],
            "variables" => [
                "nullable", "array"
            ],
            "variables.*.option_name" => [
                "required", "string", "max:100"
            ],
            "variables.*.option_value" => [
                "nullable", "string", "max:100"
            ],
            "variables.*.variable_image" => [
                "nullable", "mimes:jpeg,png,jpg",  "max:3000"
            ],
        ]);
        return $validator;
    }

    public function updateProductAttribute() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),  [
            'name' => [
                'required', 'string', 'max:99',
                Rule::unique('product_attributes', 'name')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
            'type' => [
                'required', 'string',
                Rule::in(ConstantHelper::OPTION_TYPE)
            ],
            "variables" => [
                "nullable", "array"
            ],
            "variables.*.option_name" => [
                "nullable", "string", "max:100"
            ],
            "variables.*.option_value" => [
                "nullable", "string", "max:100"
            ],
            "variables.*.variable_image" => [
                "nullable", "mimes:jpeg,png,jpg",  "max:3000"
            ],
        ]);
        return $validator;
    }

    public function storeBlogCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                Rule::unique('blog_categories', 'name')
                    ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('blog_categories', 'alias')
                    ->whereNull('deleted_at')
            ],
        ]);
        return $validator;
    }

    public function updateBlogCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                Rule::unique('blog_categories', 'name')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('blog_categories', 'alias')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
        ]);
        return $validator;
    }

    public function storeBlogPost() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'designer_id' => [
                'nullable', 
                'numeric',
                Rule::exists('designers', 'id')
            ],
            'title' => [
                'required', 'string', 'max:99'
            ],
            'description' => [
                'required', 'string', 'min:10'
            ],
            'category_id' => [
                'required',
                'numeric'
            ],
            'featured_image' => [
                "required", "file",
                "max:3000"
            ],
            'show_on_home' => [
                'required',
                'max:99'
            ]
        ]);
        return $validator;
    }

    public function updateBlogPost() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'title' => [
                'required', 'string', 'max:99'
            ],
            'description' => [
                'required', 'string', 'min:10'
            ],
            'category_id' => [
                'required',
                'numeric'
            ],
            'featured_image' => [
                "nullable", "file",
                "max:3000"
            ],
            'status' => [
                'required',
                'max:99'
            ],
            'show_on_home' => [
                'required',
                'max:99'
            ]
        ]);
        return $validator;
    }
    
    public function storeProductCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                // 'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                // Rule::unique('product_categories', 'name')
                //     ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('product_categories', 'alias')
                ->whereNull('deleted_at')
            ],
            'parent_id' => [
                'nullable', 'numeric',
                Rule::exists('product_categories', 'id')
            ],
        ]);
        return $validator;
    }

    public function updateProductCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                // 'regex:/^[a-zA-Z,\pL\s\-]+$/u',
                // Rule::unique('product_categories', 'name')
                //     ->ignore($this->request->id, 'id')
                //     ->whereNull('deleted_at')
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('product_categories', 'alias')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
            'parent_id' => [
                'nullable', 'numeric',
                Rule::exists('product_categories', 'id')
            ]
        ]);
        return $validator;
    }
    
    public function storeSlider() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'type' => [
                'required', 'string', 'max:99'
            ],
            'title' => [
                'required', 'string', 'max:99'
            ],
            'attachment_type' => [
                'required', 'string', 'max:99'
            ],
            'attachment' => [
                'required', "mimes:png,jpg,mp4,audio", 
            ],
        ]);
        return $validator;
    }

    public function updateSlider() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'type' => [
                'required', 'string', 'max:99'
            ],
            'title' => [
                'required', 'string', 'max:99'
            ],
            'attachment_type' => [
                'required', 'string', 'max:99'
            ],
            'attachment' => [
                'nullable', "mimes:png,jpg,vedio,mp4,audio", 
            ],
        ]);
        return $validator;
    }

    public function storeSocialMedia() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                // 'regex:/^[a-zA-Z,\pL\s\-]+$/u',
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('subscription_social_media', 'alias')
                    ->whereNull('deleted_at')
            ],
        ]);
        return $validator;
    }

    public function updateSocialMedia() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[ 
            'name' => [
                'required', 'string', 'max:99',
                // 'regex:/^[a-zA-Z,\pL\s\-]+$/u',
            ],
            'alias' => [
                'required', 'string', 'max:40',
                Rule::unique('subscription_social_media', 'alias')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at')
            ],
        ]);
        return $validator;
    }

    public function storeSubscriptionPlan() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'title' => [
                'required', 'string', 'max:99'
            ],
            'description' => [
                'required', 'string', 'min:10'
            ],
            'no_of_allowed_images' => [
                'required', 'numeric', 'min:0'
            ],
            'no_of_allowed_videos' => [
                'required', 'numeric', 'min:0'
            ],
            'social_media_id.*' => [
                'required', 'numeric', Rule::exists('subscription_social_media', 'id')
            ],
        ]);
        return $validator;
    }

    public function updateSubscriptionPlan() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'title' => [
                'required', 'string', 'max:99'
            ],
            'description' => [
                'required', 'string', 'min:10'
            ],
            'no_of_allowed_images' => [
                'required', 'numeric', 'min:0'
            ],
            'no_of_allowed_videos' => [
                'required', 'numeric', 'min:0'
            ],
            'social_media_id.*' => [
                'required', 'numeric', Rule::exists('subscription_social_media', 'id')
            ],
        ]);
        return $validator;
    }

   
}