<?php

namespace App\Http\Controllers;

class PopularityScoreV1Controller extends PopularityScoreController implements PopularityScoreInterface
{
    public function transformValidationResponseData($data)
    {
        return [];
    }

    public function transformNormalDataResponse($data)
    {
        return [
            'term' => $data['term'],
            'score' => $data['score']
        ];
    }
}