<?php


namespace App\Services\Api;


use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Mixed_;

class ApiResponseService
{
    private $content = [];
    private $status;
    private $errors;
    private $responseData;
    private $resultMessage;

    private function getContent(): array
    {
        return $this->content;
    }

    public function setContent(string $key , $value): ApiResponseService
    {
        $this->content[$key] = $value;
        return $this;
    }

    public function setContents(array $content): ApiResponseService
    {
        $this->content = $content;
        return $this;
    }

    private function getStatus()
    {
        return $this->status ?? config('enums.response_statuses.success') ;
    }

    public function setStatus(int $status): ApiResponseService
    {
        $this->status = $status;
        return $this;
    }

    private function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(array $errors): ApiResponseService
    {
        $this->errors = $errors;
        return $this;
    }

    public function setError(string $key , $error): ApiResponseService
    {
        $this->errors[$key] = $error;
        return $this;
    }

    private function getResultMessage()
    {
        return $this->resultMessage;
    }

    public function setResultMessage($resultMessage): ApiResponseService
    {
        $this->resultMessage = $resultMessage;
        return $this;
    }

    public function response(): Response
    {
        $this->responseData['data'] = $this->getContent();
        $this->responseData['status'] = $this->getStatus();

        if($this->getResultMessage() != null){
            $this->responseData['message'] = $this->getResultMessage();
        }

        if($this->getErrors() != null){
            $this->responseData['errors'] = $this->getErrors();
        }

        return new Response(json_encode($this->responseData) ,$this->getStatus() , [
            'content-type' => 'application/json' ,
        ]);
    }
}
