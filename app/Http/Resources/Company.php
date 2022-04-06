<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
{
    /**
     * Transform the resource into an array.
	 *
     * @OA\Response (
 	 *     response="CompanyResponse",
	 *     description="Company response",
	 *     @OA\JsonContent(ref="#/components/schemas/Company")
	 * )
	 * @OA\Schema (
	 *     schema="Company",
	 *     required={"id", "name"},
	 *     @OA\Property(property="id", type="integer", readOnly=true, example="1"),
	 *     @OA\Property(property="name", type="string", readOnly=false, example="John")
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
            'parent_company_id' => $this->parent_company_id
        ];
    }
}
