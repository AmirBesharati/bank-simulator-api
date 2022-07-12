<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserEloquentRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    protected $model = User::class;

}
