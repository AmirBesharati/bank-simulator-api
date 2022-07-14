<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'transaction_type' => $this->transactionType->title ,
            'sender_account_number' => $this->senderAccount->number ,
            'receiver_account_number' => $this->receiverAccount->number ,
            'amount' => $this->amount ,
            'currency' => config('app.currency.name') ,
            'currency_symbol' => config('app.currency.symbol') ,
            'reference_code' => $this->reference_code ,
            'created_at' => $this->created_at->format('Y-m-d H:s:i') ,
        ];
    }
}
