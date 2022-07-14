<?php

namespace App\Providers;

use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\TransactionTypeRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AccountEloquentRepository;
use App\Repositories\Eloquent\AccountTypeEloquentRepository;
use App\Repositories\Eloquent\TransactionEloquentRepository;
use App\Repositories\Eloquent\TransactionTypeEloquentRepository;
use App\Repositories\Eloquent\UserEloquentRepository;
use App\Services\Api\ApiResponseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class , UserEloquentRepository::class);
        $this->app->bind(AccountTypeRepositoryInterface::class , AccountTypeEloquentRepository::class);
        $this->app->bind(AccountRepositoryInterface::class , AccountEloquentRepository::class);
        $this->app->bind(TransactionTypeRepositoryInterface::class , TransactionTypeEloquentRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class , TransactionEloquentRepository::class);

        $this->app->bind('apiResponseService',function(){
            return new ApiResponseService();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
