<?php

namespace App\Traits;

trait ApiResponse
{

    private $meta;
    private $data;
    private $response;

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function setResponse()
    {
        $this->response['meta'] = $this->meta;

        if ($this->data !== null) {
            $this->response['data'] = $this->data;
        }
        $this->meta = array();
        $this->data = array();
        return $this->response;
    }
}
