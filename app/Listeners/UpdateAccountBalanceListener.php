<?php

namespace App\Listeners;

use App\Events\TransactionCreatedEvent;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAccountBalanceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }


    public function handle(TransactionCreatedEvent $event)
    {
        $this->accountRepository->reBalanceAccount($event->account);
    }
}
