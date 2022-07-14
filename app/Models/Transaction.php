<?php

namespace App\Models;

use App\Events\TransactionCreatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['receiver_account_id' , 'sender_account_id' , 'amount' , 'note' , 'transaction_type_id' , 'reference_code'];
}
