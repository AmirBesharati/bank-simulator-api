<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;

class TransactionEloquentRepository extends EloquentBaseRepository implements AccountTypeRepositoryInterface
{
    protected $model = Transaction::class;
}
