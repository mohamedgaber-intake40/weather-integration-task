<?php


namespace App\Utilities\ApiResponse\Builder;


use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class SuccessApiResponseBuilder extends BaseApiResponseBuilder
{
    protected $data;

    public function __construct()
    {
        $this->data       = [];
        $this->message    = __('global.response.success_message');
        $this->statusCode = Response::HTTP_OK;
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    protected function responseData()
    {
        if ($this->data instanceof JsonResource)
            return parent::responseData();

        return array_merge(parent::responseData(), [
            'data' => $this->data
        ]);
    }

    public function send()
    {
        if ($this->data instanceof JsonResource)
            return $this->data->additional(parent::responseData())->response()->setStatusCode($this->statusCode);

        return parent::send();
    }
}
