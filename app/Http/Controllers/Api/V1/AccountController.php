<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\AccountCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateAccountRequest;
use App\Http\Resources\Api\V1\AccountResource;
use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Api\ApiResponseServiceFacade;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $accountRepository;
    private $userRepository;
    private $accountTypeRepository;

    public function __construct(
        AccountRepositoryInterface $accountRepository ,
        UserRepositoryInterface $userRepository ,
        AccountTypeRepositoryInterface $accountTypeRepository
    )
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
        $this->accountTypeRepository = $accountTypeRepository;
    }

    public function create(CreateAccountRequest $request)
    {
        //find account type
        $accountType = $this->accountTypeRepository->find($request->get('account_type_id'));

        //store account
        /** @var Account $account */
        $account = $this->userRepository->storeAccount($request->user() , [
            'name' => $request->get('name') ,
            'account_type_id' => $request->get('account_type_id') ,
        ]);

        //call account created event
        event(new AccountCreatedEvent($account));


        //make account resource collection
        $account = new AccountResource($account->fresh());

        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
            ->setContent('account' , $account)
            ->response();
    }

    public function list(Request $request)
    {
        $accounts = AccountResource::collection($request->user()->accounts);

        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
            ->setContent('accounts' , $accounts)
            ->response();
    }

    public function detail(Request $request , $accountId)
    {
        $accounts = new AccountResource($request->user()->accounts()->findOrFail($accountId));

        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
            ->setContent('accounts' , $accounts)
            ->response();
    }
}
