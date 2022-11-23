<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\StoreRecordRequest;
use App\Models\City;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends Controller
{
    use ApiResponse;

    /**
     * @param StoreRecordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRecord(StoreRecordRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();

        try {

            $city = City::updateOrCreate([
                'user_id' => $userId,
                'city' => $data['city']
            ],[
                'user_id' => $userId,
                'city' => $data['city']
            ]);

            $city->weatherHistories()->create([
               'temp_in_celsius' => $data['temp_in_celsius'],
               'temp_in_fahrenheit' => $data['temp_in_fahrenheit'],
            ]);


        } catch (QueryException|\Exception $e) {
            $this->setMeta('status', config('AppConst.RESPONSE_STATUS.FAIL'));
            $this->setMeta('message', $e->getMessage());
            return response()->json($this->setResponse(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $userRecords = City::with([
            'weatherHistories'
        ])->where('user_id', $userId)->get();

        $this->setMeta('status', config('AppConst.RESPONSE_STATUS.OK'));
        $this->setMeta('message', __('messages.WeatherStoreRecordSuccess'));
        $this->setData('weather_histories', $userRecords);
        return response()->json($this->setResponse(), Response::HTTP_CREATED);
    }

    public function fetchWeatherHistories(Request $request)
    {
        $userId = Auth::id();

        $userRecords = City::with([
            'weatherHistories'
        ])->where('user_id', $userId)->get();

        $this->setMeta('status', config('AppConst.RESPONSE_STATUS.OK'));
        $this->setData('weather_histories', $userRecords);
        return response()->json($this->setResponse(), Response::HTTP_CREATED);
    }
}
