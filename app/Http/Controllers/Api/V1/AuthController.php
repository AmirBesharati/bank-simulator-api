<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Api\ApiResponseServiceFacade;
use App\Services\Api\OOOOOOOOOOApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $userEloquentRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('guest');
        $this->userEloquentRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        //store user
        $user = $this->userEloquentRepository->store([
            'name' => $request->get('name') ,
            'email' => $request->get('email') ,
            'password' => Hash::make($request->get('password')) ,
        ]);


        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
                ->setResultMessage(__('messages.api.auth.registered', ['attribute' => $user->name]))
                ->response();
    }

    public function login(LoginRequest $request)
    {
        //check user credentials
       if(Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password')])){

           //find user by entered email
           $user = $this->userEloquentRepository->findBy(['email' => $request->get('email')]);


           return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
               ->setResultMessage(__('messages.api.auth.loggedIn', ['attribute' => $user->name]))
               ->setContent('token' , $user->createToken('api')->plainTextToken)
               ->response();
       }

        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.bad_request'))
            ->setResultMessage(__('messages.api.auth.loggedInIssue', ['email' => $request->get('email')]))
            ->response();
    }

}
