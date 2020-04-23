<?php
namespace App\Services;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationJsonError
{
    /**
     * @param Validator $validator
     * @throws HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        $data= [];
        foreach ($validator->errors()->toArray() as $key => $message) {
            $data[$key] = $message;
        }

        throw new HttpResponseException(response()->json(['error' => 'variable_type_error', 'data' => $data], 422));
    }
}
