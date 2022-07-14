<?php

namespace App\Services\Transaction\AccountTransactionAvailibility;


use App\Models\Account;
use App\Services\Transaction\AccountTransactionAvailibility\Checkers\AccountActivityChecker;
use App\Services\Transaction\AccountTransactionAvailibility\Checkers\AccountBalanceChecker;
use App\Services\Transaction\AccountTransactionAvailibility\Checkers\AccountSimilarityChecker;
use App\Services\Transaction\TransactionService;

class AccountTransactionAvailability
{
    public function isAvailable(TransactionService $transactionService): bool
    {
        $accountTransactionAvailabilityChecker = new AccountActivityChecker();
        $accountTransactionAvailabilityChecker = new AccountBalanceChecker($accountTransactionAvailabilityChecker);
        $accountTransactionAvailabilityChecker = new AccountSimilarityChecker($accountTransactionAvailabilityChecker);
        return $accountTransactionAvailabilityChecker->check($transactionService);
    }
}
