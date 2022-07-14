<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\TransactionType;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;

class TransactionTypeEloquentRepository extends EloquentBaseRepository implements AccountTypeRepositoryInterface
{
    protected $model = TransactionType::class;
}
