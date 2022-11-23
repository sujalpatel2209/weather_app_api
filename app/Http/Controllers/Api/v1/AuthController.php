<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(SignUpRequest $request)
    {
        $data = $request->validated();

        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        } catch (\Exception $error) {
            $this->setMeta('status', config('AppConst.RESPONSE_STATUS.FAIL'));
            $this->setMeta('message', __('messages.500'));
            return response()->json($this->setResponse(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->setMeta('status', config('AppConst.RESPONSE_STATUS.OK'));
        $this->setMeta('message', __('messages.SignUpSuccess'));
        return response()->json($this->setResponse(), Response::HTTP_OK);
    }

    /**
     * @param SignInRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function signIn(SignInRequest $request)
    {
        $data = $request->validated();

        try {

            if (!$token = auth()->attempt($data)) {
                $this->setMeta('status', config('AppConst.RESPONSE_STATUS.FAIL'));
                $this->setMeta('message', __('messages.SignInFail'));
                return response()->json($this->setResponse(), Response::HTTP_BAD_REQUEST);
            }

            $user = Auth::user();

            $this->setMeta('status', config('AppConst.RESPONSE_STATUS.OK'));
            $this->setMeta('message', __('messages.SignInSuccess'));
            $this->setData('user', $user);
            $this->setData('token', $token);
            return response()->json($this->setResponse(), Response::HTTP_OK);

        } catch (\Exception $error) {
            $this->setMeta('status', config('AppConst.RESPONSE_STATUS.FAIL'));
            $this->setMeta('message', __('messages.500'));
            return response()->json($this->setResponse(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function guard()
    {
        return Auth::guard();
    }

}
