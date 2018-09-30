<?php

namespace App\Http\Controllers;

interface PopularityScoreInterface
{
    public function transformValidationResponseData($data);

    public function transformNormalDataResponse($data);
}