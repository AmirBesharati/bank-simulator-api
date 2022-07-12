<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Api\ApiResponseService;
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
        $this->userEloquentRepository->store([
            'name' => $request->get('name') ,
            'email' => $request->get('email') ,
            'password' => Hash::make($request->get('password')) ,
        ]);

        $apiResponseService = new ApiResponseService(config('enums.apiResponseService.statuses.success'));
        return $apiResponseService();
    }

    public function login(LoginRequest $request)
    {
        //check user credentials
       if(Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password')])){

           //find user by entered email
           $user = $this->userEloquentRepository->findBy(['email' => $request->get('email')]);

           //auth user
           $apiResponseService = new ApiResponseService(config('enums.apiResponseService.statuses.error'));
           $apiResponseService->content['token'] =  $user->createToken('api')->plainTextToken;
           return $apiResponseService();
       }

       $apiResponseService = new ApiResponseService(config('enums.apiResponseService.statuses.error'));
       return $apiResponseService();
    }

}
