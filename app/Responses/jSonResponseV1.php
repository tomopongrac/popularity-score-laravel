<?php

namespace App\Responses;

class jSonResponseV1 implements ResponseInterface
{
    public $responseHeader = [];

    /**
     * @param $data
     * @return array
     */
    public function transformValidationResponseData($data)
    {
        return [];
    }

    /**
     * @param $data
     * @return array
     */
    public function transformNormalDataResponse($data)
    {
        return [
            'term' => $data['term'],
            'score' => $data['score']
        ];
    }

    /**
     * @return array
     */
    public function getResponseHeader()
    {
        return [];
    }
}