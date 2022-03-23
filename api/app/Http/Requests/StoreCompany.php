<?php

namespace App\Http\Requests;

use App\DTOs\Company;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompany extends FormRequest
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
            'name' => 'required|string',
            'parent_company_id' => 'nullable|exists:companies,id',
        ];
    }

    public function dto(): Company
    {
        return new Company(
            $this->input('name'),
            $this->input('parent_company_id')
        );
    }
}
