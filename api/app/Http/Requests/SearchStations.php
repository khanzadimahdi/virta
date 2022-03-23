<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchStations extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'latitude' => 'required|numeric|gt:-90|lt:90',
            'longitude' => 'required|numeric|gt:-180|lt:180',
            'company_id' => 'nullable|numeric',
            'distance' => 'nullable|numeric|gt:0',
        ];
    }
}
