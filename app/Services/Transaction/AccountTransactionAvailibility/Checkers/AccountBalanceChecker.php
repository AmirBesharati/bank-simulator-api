<?php

namespace App\Services\Transaction\AccountTransactionAvailibility\Checkers;

use App\Models\Account;
use App\Services\Transaction\TransactionService;

class AccountBalanceChecker extends AccountAvailabilityChecker
{
    public function check(TransactionService $transactionService)
    {
//        if(!$account->balance < $transactionService->getAmount() + fee of transaction){
        if($transactionService->getSenderAccount()->balance < $transactionService->getAmount()){
            return false;
        }
        return parent::check($transactionService);
    }
}
