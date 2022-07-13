<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;

class AccountEloquentRepository extends EloquentBaseRepository implements AccountRepositoryInterface
{
    protected $model = Account::class;

    public function generateUniqueAccountNumber(): int
    {
        $number = mt_rand(100000000, 999999999); // better than rand()

        // call the same function if the number exists already
        if($this->model::whereNumber($number)->exists()){
            return $this->generateUniqueAccountNumber();
        }

        return $number;
    }
}
