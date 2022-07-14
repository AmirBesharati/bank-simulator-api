<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Models\Transaction;
use App\QueryBuilders\Eloquent\TransactionEloquentQueryBuilder;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class TransactionEloquentRepository extends EloquentBaseRepository implements TransactionRepositoryInterface
{
    protected $model = Transaction::class;

    private $transactionEloquentQueryBuilder;

    public function __construct(TransactionEloquentQueryBuilder $transactionEloquentQueryBuilder)
    {
        $this->transactionEloquentQueryBuilder = $transactionEloquentQueryBuilder;
    }

    public function generateUniqueReferenceCode()
    {
        $number = mt_rand(100000000, 999999999); // better than rand()

        // call the same function if the number exists already
        if($this->model::whereReferenceCode($number)->exists()){
            return $this->generateUniqueReferenceCode();
        }

        return $number;
    }

    public function filter(Account $account, Request $request)
    {
        return $this
            ->transactionEloquentQueryBuilder
            ->setAccountId($account->id)
            ->makeObjectFromRequest($request)->getResult();
    }
}
