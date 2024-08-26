<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'name' => 'required|min:3',
            'mobile' => 'required|min:10',
            'email' => 'required|email',
            'address' => 'nullable|string|max:150', 
            'password' => 'string|between:6,20|nullable|confirmed',
            'gender' => 'required|string', 
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

}
