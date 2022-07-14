<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionEloquentRepository extends EloquentBaseRepository implements TransactionRepositoryInterface
{
    protected $model = Transaction::class;

    public function generateUniqueReferenceCode()
    {
        $number = mt_rand(100000000, 999999999); // better than rand()

        // call the same function if the number exists already
        if($this->model::whereReferenceCode($number)->exists()){
            return $this->generateUniqueReferenceCode();
        }

        return $number;
    }

}
