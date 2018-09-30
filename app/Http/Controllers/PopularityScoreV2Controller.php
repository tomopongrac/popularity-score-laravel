<?php

namespace App\Http\Controllers;

class PopularityScoreV2Controller extends PopularityScoreController implements PopularityScoreInterface
{

    protected $responseHeader = [
        'Accept' => 'application/vnd.api+json',
    ];

    public function transformValidationResponseData($data)
    {
        return [
            'error' => [
                'message' => 'Riječ mora biti upisana.'
            ]
        ];
    }

    public function transformNormalDataResponse($data)
    {
        return [
            'data' => [
                'term' => $data['term'],
                'score' => $data['score']
            ]
        ];
    }
}