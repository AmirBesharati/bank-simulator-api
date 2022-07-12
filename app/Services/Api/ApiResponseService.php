<?php


namespace App\Services\Api;


use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ApiResponseService
{
    public $content = [];
    private $status;

    private $response;
    private $resultMessage;

    /**
     * WebserviceResponse constructor.
     * @param $result_code
     * @param null $resultMessage
     */
    public function __construct($status, $resultMessage = null)
    {
        $this->status = $status;
        if(!is_null($resultMessage)){
            $this->resultMessage = $resultMessage;
        }
    }

    public function __invoke(): Response
    {
        $this->response['data'] = $this->content;
        $this->response['status'] = $this->status;
        if($this->getResultMessage() != null){
            $this->response['message'] = $this->getResultMessage();
        }

        return new Response(json_encode($this->response) ,200 , [
            'content-type' => 'application/json' ,
        ]);
    }

    public function getResultMessage()
    {
        return $this->resultMessage;
    }

    public function addPaginator(ResourceCollection $resource)
    {
        $this->content['pagination'] = [
            'current_page'=> $resource->currentPage(),
            'total_items'=> $resource->total() ,
            'total_pages'=> $resource->LastPage(),
        ];
    }
}
