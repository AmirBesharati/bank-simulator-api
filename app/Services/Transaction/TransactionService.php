<?php

namespace App\Services\Transaction;

use App\Events\TransactionCreatedEvent;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\TransactionTypeRepositoryInterface;
use App\Services\Transaction\AccountTransactionAvailibility\AccountTransactionAvailability;
use InvalidArgumentException;
use Psy\Readline\Hoa\Event;

class TransactionService implements TransactionServiceInterface
{

    private $accountRepository;
    private $transactionTypeRepository;
    private $transactionRepository;

    private $senderAccount = null;
    private $receiverAccount = null;
    private $note = null;
    private $amount = null;
    private $transactionType;

    public function __construct(
        AccountRepositoryInterface         $accountRepository,
        TransactionTypeRepositoryInterface $transactionTypeRepository ,
        TransactionRepositoryInterface $transactionRepository
    )
    {
        $this->accountRepository = $accountRepository;
        $this->transactionTypeRepository = $transactionTypeRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function getTransactionType()
    {
        return $this->transactionType;
    }

    public function getSenderAccount()
    {
        return $this->senderAccount;
    }

    public function setSenderAccount($senderAccount): TransactionService
    {
        $this->senderAccount = $senderAccount;
        return $this;
    }

    public function getReceiverAccount()
    {
        return $this->receiverAccount;
    }

    public function setReceiverAccount($receiverAccount): TransactionService
    {
        $this->receiverAccount = $receiverAccount;
        return $this;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note): TransactionService
    {
        $this->note = $note;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): TransactionService
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @description : the majority of this function is to handle transaction between accounts and check transaction
     *  arguments with chain of checkers also its support other types of transactions, that should be defined in transaction types
     *
     */
    public function doTransaction():?Transaction
    {
        try {
            $this->accountRepository->beginTransaction();

            //check necessary properties
            if (is_null($this->getAmount()) or is_null($this->getSenderAccount()) or is_null($this->getReceiverAccount())) {
                throw new InvalidArgumentException();
            }

            //find transaction type id
            $transactionTypeId = $this->receiverAccount->user_id == $this->senderAccount->user_id
                ? config('enums.transaction_types.INTERNAL.id')
                : config('enums.transaction_types.EXTERNAL.id');


            //get transaction type model
            $this->transactionType = $this->transactionTypeRepository->findOrFail($transactionTypeId);


            //check account availability to do transaction with chain of responsibilities
            if (!(new AccountTransactionAvailability)->isAvailable($this)) {
                throw new \Exception(__('messages.errors.transaction.make'));
            }



            //create transaction record
            $transaction = $this->accountRepository->sendTransaction($this->getSenderAccount(), [
                'receiver_account_id' => $this->getReceiverAccount()->id,
                'amount' => $this->getAmount(),
                'note' => $this->getNote(),
                'transaction_type_id' => $this->getTransactionType()->id ,
                'reference_code' => $this->transactionRepository->generateUniqueReferenceCode() ,
            ]);

            //call transaction created for both accounts
            event(new TransactionCreatedEvent($this->getReceiverAccount()));
            event(new TransactionCreatedEvent($this->getSenderAccount()));

            $this->accountRepository->commit();

            return $transaction;
        } catch (\Exception $exception) {
            $this->accountRepository->rollback();
        }

        return null;
    }
}
