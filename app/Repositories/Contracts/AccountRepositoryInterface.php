<?php

namespace App\Repositories\Contracts;

use App\Models\Account;

interface AccountRepositoryInterface
{
    public function generateUniqueAccountNumber();

    public function transaction(Account $senderAccount, array $array);
}
