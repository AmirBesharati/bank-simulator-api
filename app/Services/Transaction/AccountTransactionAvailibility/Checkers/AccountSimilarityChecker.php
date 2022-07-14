<?php

namespace App\Services\Transaction\AccountTransactionAvailibility\Checkers;

use App\Models\Account;
use App\Services\Transaction\TransactionService;

class AccountSimilarityChecker extends AccountAvailabilityChecker
{
    public function check(TransactionService $transactionService)
    {
        if($transactionService->getSenderAccount()->id == $transactionService->getReceiverAccount()->id){
            return false;
        }
        return parent::check($transactionService);
    }
}
