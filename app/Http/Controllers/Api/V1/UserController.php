<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\Api\ApiResponseServiceFacade;
use App\Services\Api\OOOOOOOOOOApiResponseService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        //make user resource
        $user = new UserResource($request->user());


        return ApiResponseServiceFacade::setStatus(config('enums.response_statuses.success'))
            ->setResultMessage(__('messages.api.auth.loggedIn', ['attribute' => $user->name]))
            ->setContent('user' , $user)
            ->response();
    }
}
