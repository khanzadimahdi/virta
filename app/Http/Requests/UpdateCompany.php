<?php

namespace App\Http\Requests;

use App\DTOs\Company;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody (
 *   request="UpdateCompanyRequestBody",
 *   required=true,
 *   description="store company request body",
 *   @OA\JsonContent(ref="#/components/schemas/UpdateCompanyRequest")
 * )
 *
 * @OA\Schema (
 *     schema="UpdateCompanyRequest",
 *     required={"name", "parent_company_id"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="parent_company_id", type="integer", example="1")
 * )
 *
 * @OA\Schema (
 *     schema="InvalidUpdateCompanyRequest",
 *     @OA\Property(
 *         property="name",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             example={"The name field is invalid."},
 *         )
 *     ),
 *     @OA\Property(
 *         property="parent_company_id",
 *         type="array",
 *         @OA\Items(
 *             type="integer",
 *             example={"The parent_company_id field is invalid."},
 *         )
 *     )
 * )
 */
class UpdateCompany extends FormRequest
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
