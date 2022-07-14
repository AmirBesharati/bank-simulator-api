<?php

namespace App\Services\Transaction\AccountTransactionAvailibility\Checkers;

use App\Models\Account;
use App\Models\TransactionType;
use App\Services\Transaction\TransactionService;

abstract class AccountAvailabilityChecker
{
    private $nextChecker;

    public function __construct(self $nextChecker = null)
    {
        $this->nextChecker = $nextChecker;
    }

    public function check(TransactionService $transactionService)
    {
        if ($this->nextChecker) {
            return $this->nextChecker->check($transactionService);
        }
        return true;
    }
}
