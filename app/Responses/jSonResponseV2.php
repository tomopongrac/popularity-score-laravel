<?php

namespace App\Responses;

class jSonResponseV2 implements ResponseInterface
{

    /**
     * @param $data
     * @return array
     */
    public function transformValidationResponseData($data)
    {
        return [
            'error' => [
                'message' => 'Riječ mora biti upisana.'
            ]
        ];
    }

    /**
     * @param $data
     * @return array
     */
    public function transformNormalDataResponse($data)
    {
        return [
            'data' => [
                'term' => $data['term'],
                'score' => $data['score']
            ]
        ];
    }

    /**
     * @return array
     */
    public function getResponseHeader()
    {
        return [
            'Accept' => 'application/vnd.api+json',
        ];
    }
}