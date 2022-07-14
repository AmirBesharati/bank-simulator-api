<?php

namespace App\Models;

use App\Events\TransactionCreatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['receiver_account_id' , 'sender_account_id' , 'amount' , 'note' , 'transaction_type_id' , 'reference_code'];

    public function transactionType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TransactionType::class , 'transaction_type_id' , 'id');
    }

    public function senderAccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class , 'sender_account_id' , 'id');
    }

    public function receiverAccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class , 'receiver_account_id' , 'id');
    }

}
