<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;

class AccountEloquentRepository extends EloquentBaseRepository implements AccountRepositoryInterface
{
    protected $model = Account::class;
}
