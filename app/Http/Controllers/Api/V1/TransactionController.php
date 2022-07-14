<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Http\Resources\Api\V1\TransactionResource;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Api\ApiResponseServiceFacade;
use App\Services\Transaction\TransactionService;
use App\Services\Transaction\TransactionServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $accountRepository;
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository ,
        AccountRepositoryInterface $accountRepository)
    {
        $this->userRepository = $userRepository;
        $this->accountRepository = $accountRepository;
    }

    public function create(TransactionRequest $request , $accountId , TransactionServiceInterface $transactionService)
    {
        $accountNumber = $request->get('account_number');
        $amount = $request->get('amount');
        $note = $request->get('note');

        //find sender account
        $senderAccount = $this->userRepository->account($request->user() , $accountId);

        //find destination account
        $receiverAccount = $this->accountRepository->findBy(['number' => $accountNumber] , null , [] , true);

        //do transaction
        $transaction = $transactionService
            ->setAmount($amount)
            ->setSenderAccount($senderAccount)
            ->setReceiverAccount($receiverAccount)
            ->setNote($note)
            ->doTransaction();

        if(is_null($transaction)){
            return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.bad_request'))
                ->setResultMessage(__('messages.errors.transaction.make'))
                ->response();
        }

        $transaction = new TransactionResource($transaction);

        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
            ->setContent('transaction' , $transaction)
            ->response();
    }
}
