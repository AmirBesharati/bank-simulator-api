<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'email' => $this->email ,
            'name' => $this->name ,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
