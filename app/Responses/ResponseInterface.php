<?php

namespace App\Responses;

interface ResponseInterface
{
    /**
     * Get data for response for validation error
     *
     * @param $data
     * @return mixed
     */
    public function transformValidationResponseData($data);

    /**
     * Get data for response which is normal
     *
     * @param $data
     * @return mixed
     */
    public function transformNormalDataResponse($data);

    /**
     * Header for response
     *
     * @return mixed
     */
    public function getResponseHeader();
}