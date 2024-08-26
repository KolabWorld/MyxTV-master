<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientAddressRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = array(
			'alias' => 'required|string|max:50', 
			'address_name' => 'nullable|string|max:150', 
			'mobile' => 'nullable|string|max:15', 
			'phone' => 'nullable|string|max:15', 
			'address_1' => 'nullable|string|max:150', 
			'address_2' => 'nullable|string|max:150', 
			'city' => 'nullable|string|max:50', 
			'state_id' => 'nullable|string|max:50', 
			'state_code' => 'nullable|string|max:15', 
			'zip' => 'nullable|string|max:15', 
			'country' => 'nullable|string|max:50', 
        );

		return $rules;

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
