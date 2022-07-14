<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{

    public function storeAccount(User $user , array $items);

    public function account(User $user ,int $accountId);
}
