<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest {

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
			'description' => 'nullable|string|max:2000',
        );
		
		if ($this->_method == 'PUT') {
			$rules = array(
                'name' => 'required|string|max:100',
                'email' => 'nullable|email|max:255',
            );
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
