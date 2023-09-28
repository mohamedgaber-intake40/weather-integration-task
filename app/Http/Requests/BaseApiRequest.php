<?php

namespace Modules\Common\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        if (!count($errors)) return null;

            $transformedErrors = [];
            foreach ($errors as $field => $messages) {
                $transformedErrors[$field] = $messages[0];
            }
            return apiResponse()->error()
                                ->withErrors($transformedErrors)
                                ->statusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                                ->message(__('global.response.validation_message'))
                                ->send();

    }


}
