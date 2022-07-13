<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\AccountResource;
use App\Http\Resources\Api\V1\AccountTypeResource;
use App\Repositories\Contracts\AccountTypeRepositoryInterface;
use App\Services\Api\ApiResponseServiceFacade;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    private $accountTypeRepository;

    public function __construct(AccountTypeRepositoryInterface $accountTypeRepository)
    {
        $this->accountTypeRepository = $accountTypeRepository;
    }

    public function list()
    {
        $accountTypes = AccountTypeResource::collection($this->accountTypeRepository->all());

        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
            ->setContent('account_types' , $accountTypes)
            ->response();
    }
}
