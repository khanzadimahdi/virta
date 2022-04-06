<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StationCollection extends ResourceCollection
{
    public static $wrap = 'data';

    public $collects = Station::class;

    /**
     * Transform the resource collection into an array.
	 *
 	 * @OA\Response (
	 *     response="StationCollectionResponse",
	 *     description="Station collection response",
	 *     @OA\JsonContent(ref="#/components/schemas/StationCollection")
	 * )
	 * @OA\Schema (
	 *     schema="StationCollection",
	 *     type="object",
	 *     allOf={
	 *         @OA\Schema(
	 *             @OA\Property(
	 *                 property="data",
	 *                 type="array",
	 *                 @OA\Items(ref="#/components/schemas/Station")
	 *             )
	 *         ),
	 *         @OA\Schema(ref="#/components/schemas/Pagination")
	 *     }
	 * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
