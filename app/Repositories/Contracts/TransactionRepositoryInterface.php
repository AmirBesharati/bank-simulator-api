<?php

namespace App\Repositories\Contracts;

use App\Models\Account;
use Illuminate\Http\Request;

interface TransactionRepositoryInterface
{
    public function generateUniqueReferenceCode();

    public function filter(Account $account , Request $request);
}
