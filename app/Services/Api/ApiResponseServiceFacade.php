<?php


namespace App\Services\Api;


use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Types\Mixed_;



/**

 *
 * @method static ApiResponseService setContent(string $key , Mixed_ $value)
 * @method static ApiResponseService setContents(array $contents)
 * @method static ApiResponseService setStatus(int $status)
 * @method static ApiResponseService setErrors(array $errors)
 * @method static ApiResponseService setError(string $key , Mixed_ $error)
 * @method static ApiResponseService setResultMessage(string $message)
 * @method static Response response()
 * @see ApiResponseService
 */

class ApiResponseServiceFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'apiResponseService';
    }
}
