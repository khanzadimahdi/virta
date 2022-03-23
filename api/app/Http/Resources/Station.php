<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="Station",
 *     description="Station resource",
 *     @OA\Xml(
 *         name="Station"
 *     )
 * )
 */
class Station extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
            $this->mergeWhen($this->company, [
                'company' => new Company($this->company)
            ]),

            // related children (child company stations)
            $this->mergeWhen(isset($this->children), [
                'children' => empty($this->children) ? [] : Station::collection(collect($this->children->all()))
            ])
        ];
    }
}
