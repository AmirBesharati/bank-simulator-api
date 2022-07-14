<?php

namespace App\Listeners;

use App\Events\AccountCreatedEvent;
use App\Events\TransactionCreatedEvent;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddTransactionForCreatedAccountListener
{
    private $transactionRepository;
    private $accountRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository , AccountRepositoryInterface $accountRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;
    }

    public function handle(AccountCreatedEvent $event)
    {
        $this->accountRepository->createInitialAccountTransaction($event->account , $event->account->accountType , $this->transactionRepository->generateUniqueReferenceCode());
    }
}
