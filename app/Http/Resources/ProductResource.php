<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => 'products',
            'id' => (string) $this->id,
            'attributes' => [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->type,
                'category' => $this->category,
                'quantity' => $this->quantity,
                'unit_cost' => $this->unit_cost,
                'manufacturer' => $this->manufacturer,
                'distributor' => $this->distributor,
                'user' => [
                    'id' => $this->user_id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
        ];
    }
}
