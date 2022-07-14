<?php

namespace App\Services\Transaction;

use App\Models\Account;
use App\Models\Transaction;
use PhpParser\Node\Expr\Cast\Double;

interface TransactionServiceInterface
{
    public function getSenderAccount();
    public function setSenderAccount(Account $senderAccount):TransactionService;
    public function getReceiverAccount();
    public function setReceiverAccount(Account $receiverAccount):TransactionService;
    public function getNote();
    public function setNote(string $note):TransactionService;
    public function getAmount();
    public function setAmount(double $amount):TransactionService;

    public function doTransaction():?Transaction;
}
