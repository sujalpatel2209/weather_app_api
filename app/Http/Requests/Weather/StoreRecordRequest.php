<?php

namespace App\Http\Requests\Weather;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city' => 'required',
            'temp_in_celsius' => 'required',
            'temp_in_fahrenheit' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(["meta" => [
            'status' => config('AppConst.RESPONSE_STATUS.FAIL'),
            'message' => $validator->errors()->first()
        ]], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
