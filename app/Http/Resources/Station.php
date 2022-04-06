<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Station extends JsonResource
{
    /**
     * Transform the resource into an array.
	 *
     * @OA\Response (
 	 *     response="StationResponse",
	 *     description="Station response",
	 *     @OA\JsonContent(ref="#/components/schemas/Station")
	 * )
	 * @OA\Schema (
	 *     schema="Station",
	 *     required={"id", "name"},
	 *     @OA\Property(property="id", type="integer", readOnly=true, example="1"),
	 *     @OA\Property(property="name", type="string", readOnly=false, example="John"),
	 *     @OA\Property(property="latitude", type="float", readOnly=false, example="95.6"),
	 *     @OA\Property(property="longitude", type="float", readOnly=false, example="97.25"),
	 *     @OA\Property(property="company_id", type="integer", readOnly=false, example="1"),
	 *     @OA\Property(property="address", type="string", readOnly=false, example="a simple address")
	 * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'company_id' => $this->company_id,
            'address' => $this->address,

            // related company
            $this->mergeWhen(
                $this->company, [
                'company' => new Company($this->company)
                ]
            ),

            // related children (child company stations)
            $this->mergeWhen(
                isset($this->children), [
                'children' => empty($this->children) ? [] : Station::collection(collect($this->children->all()))
                ]
            )
        ];
    }
}
