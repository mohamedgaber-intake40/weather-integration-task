<?php


namespace App\Utilities\ApiResponse\Builder;


use Symfony\Component\HttpFoundation\Response;

class ErrorApiResponseBuilder extends BaseApiResponseBuilder
{
    protected $errors;

    public function __construct()
    {
        $this->errors     = [];
        $this->message    = __('global.response.error_message');
        $this->statusCode = Response::HTTP_BAD_REQUEST;
    }

    public function withErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    protected function responseData()
    {
        return array_merge(parent::responseData(), [
            'errors' => $this->errors
        ]);
    }

}
