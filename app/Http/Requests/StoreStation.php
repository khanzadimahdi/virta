<?php

namespace App\Http\Requests;

use App\DTOs\Station;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody (
 *   request="StoreStationRequestBody",
 *   required=true,
 *   description="store station request body",
 *   @OA\JsonContent(ref="#/components/schemas/StoreStationRequest")
 * )
 *
 * @OA\Schema (
 *     schema="StoreStationRequest",
 *     required={"name", "latitude", "longitude", "company_id", "address"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="latitude", type="float", example="75.65"),
 *     @OA\Property(property="longitude", type="float", example="120.75"),
 *     @OA\Property(property="company_id", type="integer", example="1"),
 *     @OA\Property(property="address", type="string", example="5th avenue, nex to the bank")
 * )
 *
 * @OA\Schema (
 *     schema="InvalidStoreStationRequest",
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
class StoreStation extends FormRequest
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
            'latitude' => 'required|numeric|gte:-90|lte:90',
            'longitude' => 'required|numeric|gte:-180|lte:180',
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
