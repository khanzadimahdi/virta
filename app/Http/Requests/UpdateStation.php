<?php

namespace App\Http\Requests;

use App\DTOs\Station;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody (
 *   request="UpdateStationRequestBody",
 *   required=true,
 *   description="store station request body",
 *   @OA\JsonContent(ref="#/components/schemas/UpdateStationRequest")
 * )
 *
 * @OA\Schema (
 *     schema="UpdateStationRequest",
 *     required={"name", "latitude", "longitude", "company_id", "address"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="latitude", type="float", example="95.65"),
 *     @OA\Property(property="longitude", type="float", example="120.75"),
 *     @OA\Property(property="company_id", type="integer", example="1"),
 *     @OA\Property(property="address", type="string", example="5th avenue, nex to the bank")
 * )
 *
 * @OA\Schema (
 *     schema="InvalidUpdateStationRequest",
 *     @OA\Property(
 *         property="name",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             example={"The name field is invalid."},
 *         )
 *     ),
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
 *         property="address",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             example={"The address field is invalid."},
 *         )
 *     )
 * )
 */
class UpdateStation extends FormRequest
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
            'latitude' => 'required|numeric|gt:-90|lt:90',
            'longitude' => 'required|numeric|gt:-180|lt:180',
            'company_id' => 'required|exists:companies,id',
            'address' => 'required|string',
        ];
    }

    public function dto(): Station
    {
        return new Station(
            $this->input('name'),
            $this->input('latitude'),
            $this->input('longitude'),
            $this->input('company_id'),
            $this->input('address'),
        );
    }
}
