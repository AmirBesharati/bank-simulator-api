<?php

namespace App\Services\Transaction\AccountTransactionAvailibility\Checkers;

use App\Models\Account;
use App\Services\Transaction\TransactionService;

class AccountActivityChecker extends AccountAvailabilityChecker
{
    public function check(TransactionService $transactionService)
    {
        if(!$transactionService->getSenderAccount()->is_active && !$transactionService->getReceiverAccount()->is_active){
            return false;
        }
        return parent::check($transactionService);
    }
}
