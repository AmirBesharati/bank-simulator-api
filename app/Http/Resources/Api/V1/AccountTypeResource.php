<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountTypeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'description' => $this->description ,
            'start_balance' => $this->when(request()->routeIs('api.v1.account.type.list') , function (){
                return $this->start_balance . config('app.currency.symbol');
            })
        ];
    }
}
