<?php

namespace App\Responses;

interface ResponseInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function transformValidationResponseData($data);

    /**
     * @param $data
     * @return mixed
     */
    public function transformNormalDataResponse($data);

    /**
     * @return mixed
     */
    public function getResponseHeader();
}