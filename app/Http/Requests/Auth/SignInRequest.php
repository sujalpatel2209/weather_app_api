<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SignInRequest extends FormRequest
{
    use ApiResponse;
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
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(["meta" => [
            'status' => config('AppConst.RESPONSE_STATUS.FAIL'),
            'message' => $validator->errors()->first()
        ]], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
