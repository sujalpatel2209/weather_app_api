<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtVerify
{
    use ApiResponse;

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        try {
            JWTAuth::setToken($token);
            if($token == null) {
                $this->setMeta('status', config('AppConst.RESPONSE_STATUS.FAIL'));
                $this->setMeta('message', __('messages.404'));
                return response()->json($this->setResponse(), Response::HTTP_NOT_FOUND);
            } else if (!$claim = JWTAuth::getPayload()) {
                $this->setMeta('status', config('AppConst.RESPONSE_STATUS.FAIL'));
                $this->setMeta('message', __('messages.404'));
                return response()->json($this->setResponse(), Response::HTTP_NOT_FOUND);
            }
        } catch (TokenExpiredException|TokenInvalidException|JWTException $e) {
            $this->setMeta('status', config('AppConst.RESPONSE_STATUS.FAIL'));
            $this->setMeta('message', $e->getMessage());
            return response()->json($this->setResponse(), Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
