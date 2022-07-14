<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\TransactionType;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;
use App\Repositories\Contracts\TransactionTypeRepositoryInterface;

class TransactionTypeEloquentRepository extends EloquentBaseRepository implements TransactionTypeRepositoryInterface
{
    protected $model = TransactionType::class;
}
