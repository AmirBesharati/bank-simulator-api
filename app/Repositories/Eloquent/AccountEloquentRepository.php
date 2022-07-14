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

    public function transaction(Account $senderAccount, array $array): \Illuminate\Database\Eloquent\Model
    {

        return $senderAccount->sentTransactions()->create($array);
    }

    /**
     * @description : sum received transaction and sent transaction amount to calculate account balance
     */
    public function reBalanceAccount(Account $account): bool
    {
        $balance = $account->receivedTransactions()->sum('amount') - $account->sentTransactions()->sum('amount');

        return $this->updateWithinModel($account , ['balance' => $balance]);
    }
}
