<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'balance' => $this->balance ,
            'currency' => config('app.currency.name') ,
            'account_number' =>  $this->number ,
            'currency_symbol' => config('app.currency.symbol') ,
            'account_type' => new AccountTypeResource($this->accountType)
        ];
    }
}
