<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(AccountRepositoryInterface $accountRepository)
    {

    }

    public function create(TransactionRequest $request)
    {
        $accountNumber = $request->get('account_number');
        $amount = $request->get('amount');
    }
}
