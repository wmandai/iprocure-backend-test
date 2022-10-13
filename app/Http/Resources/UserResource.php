<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type' => 'users',
            'id' => (string) $this->id,
            'attributes' => [
                'id' => $this->id,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'phone' => $this->phoneNumber,
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
        ];
    }
}
