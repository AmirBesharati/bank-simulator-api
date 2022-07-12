<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\Api\ApiResponseService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        //make user resource
        $user = new UserResource($request->user());

        $apiResponseService = new ApiResponseService(config('enums.apiResponseService.statuses.success'));
        $apiResponseService->content['user'] = $user;
        return $apiResponseService();
    }
}
