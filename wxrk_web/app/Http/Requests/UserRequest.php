<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

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
            'email' => 'required|email|unique:users',
            'password' => 'string|between:6,20|required|confirmed',
            'address' => 'nullable|string|max:150', 
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
