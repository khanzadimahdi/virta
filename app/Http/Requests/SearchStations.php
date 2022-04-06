<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Parameter(
 *     parameter="SearchStationsLatitude",
 *     name="latitude",
 *     in="query",
 *     required=true,
 *     description="latitude",
 *     @OA\Schema(type="float")
 * ),
 * @OA\Parameter(
 *     parameter="SearchStationsLongitude",
 *     name="longitude",
 *     in="query",
 *     required=true,
 *     description="longitude",
 *     @OA\Schema(type="float")
 * ),
 * @OA\Parameter(
 *     parameter="SearchStationsCompanyID",
 *     name="company_id",
 *     in="query",
 *     required=false,
 *     description="related comany's id",
 *     @OA\Schema(type="integer")
 * ),
 * @OA\Parameter(
 *     parameter="SearchStationsDistance",
 *     name="distance",
 *     in="query",
 *     required=false,
 *     description="max distance to station",
 *     @OA\Schema(type="float")
 * ),
 * @OA\Parameter(
 *     parameter="Page",
 *     name="page",
 *     in="query",
 *     required=false,
 *     description="Page number.",
 *     @OA\Schema(type="integer")
 * ),
 * @OA\Parameter(
 *     parameter="PerPage",
 *     name="perPage",
 *     in="query",
 *     required=false,
 *     description="number of elements per page.",
 *     @OA\Schema(type="integer")
 * )
 *
 * @OA\Schema (
 *     schema="InvalidSearchStationsRequest",
 *     @OA\Property(
 *         property="latitude",
 *         type="array",
 *         @OA\Items(
 *             type="float",
 *             example={"The latitude field is invalid."},
 *         )
 *     ),
 *     @OA\Property(
 *         property="longitude",
 *         type="array",
 *         @OA\Items(
 *             type="float",
 *             example={"The longitude field is invalid."},
 *         )
 *     ),
 *     @OA\Property(
 *         property="company_id",
 *         type="array",
 *         @OA\Items(
 *             type="integer",
 *             example={"The company_id field is invalid."},
 *         )
 *     ),
 *     @OA\Property(
 *         property="distance",
 *         type="array",
 *         @OA\Items(
 *             type="float",
 *             example={"The distance field is invalid."},
 *         )
 *     )
 * )
 */
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
