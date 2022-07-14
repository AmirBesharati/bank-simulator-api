<?php

namespace App\Repositories\Contracts;

use App\Models\Account;
use App\Models\AccountType;

interface AccountRepositoryInterface
{
    public function generateUniqueAccountNumber();

    public function sendTransaction(Account $senderAccount, array $array);

    public function createInitialAccountTransaction(Account $receiverAccount, AccountType $accountType , $referenceCode);
}
