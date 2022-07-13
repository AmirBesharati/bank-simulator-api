<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Models\AccountType;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;

class AccountTypeEloquentRepository extends EloquentBaseRepository implements AccountTypeRepositoryInterface
{
    protected $model = AccountType::class;
}
