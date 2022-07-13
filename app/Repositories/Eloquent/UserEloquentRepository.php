<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserEloquentRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    protected $model = User::class;

    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function storeAccount(User $user, array $items): \Illuminate\Database\Eloquent\Model
    {
        $number = $this->accountRepository->generateUniqueAccountNumber();

        return $user->accounts()->create(array_merge($items , ['number' => $number]));
    }
}
