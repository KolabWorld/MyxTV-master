<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = array(
			'name' => 'required|string|max:100',
			'email' => 'nullable|email|max:255',
			'alias' => 'nullable|string|max:50', 
			'mobile' => 'nullable|string|max:15', 
			'phone' => 'nullable|string|max:15', 
			'pan_no' => 'nullable|string|max:15', 
			'gstin' => 'nullable|string|max:50', 
			'website' => 'nullable|string|max:100', 
			'address1' => 'nullable|string|max:150', 
			'address2' => 'nullable|string|max:150', 
			'city' => 'nullable|string|max:50', 
			'state_id' => 'nullable|string|max:50', 
			'state_code' => 'nullable|string|max:15', 
			'zip' => 'nullable|string|max:15', 
			'country' => 'nullable|string|max:50', 
			'series_invoice' => 'nullable|numeric', 
			'series_quotation' => 'nullable|numeric', 
            );
		
		if ($this->_method == 'PUT') {
			$rules['email'] = 'required|email|max:255';
		}
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
