<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(Request $request)
    {
        $this->accountRepository->store([

        ]);
    }
}
