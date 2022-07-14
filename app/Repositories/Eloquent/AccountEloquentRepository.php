<?php

namespace App\Repositories\Eloquent;

use App\Events\TransactionCreatedEvent;
use App\Models\Account;
use App\Models\AccountType;
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

    public function sendTransaction(Account $senderAccount, array $array): \Illuminate\Database\Eloquent\Model
    {
        return $senderAccount->sentTransactions()->create($array);
    }

    public function createInitialAccountTransaction(Account $receiverAccount , AccountType $accountType , $referenceCode )
    {
        $receiverAccount->receivedTransactions()->create([
            'amount' => $accountType->start_balance ,
            'note' => 'Create account reward' ,
            'transaction_type_id' => config('enums.transaction_types.CREATE_ACCOUNT.id') ,
            'reference_code' =>  $referenceCode ,
        ]);

        //call transaction created event
        event(new TransactionCreatedEvent($receiverAccount));
    }

    /**
     * @description : sum received transaction and sent transaction amount to calculate account balance
     */
    public function reBalanceAccount(Account $account)
    {
        $balance = $account->receivedTransactions()->sum('amount') - $account->sentTransactions()->sum('amount');

        $this->updateWithinModel($account , ['balance' => $balance]);
    }
}
