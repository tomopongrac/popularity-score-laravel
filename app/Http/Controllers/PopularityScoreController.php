<?php

namespace App\Http\Controllers;

use App\Exceptions\NoTermInDbException;
use App\PopularityResult;
use App\Services\ServiceProvider;

abstract class PopularityScoreController extends Controller
{

    protected $statusCode;
    protected $responseHeader = [];
    /**
     * @var ServiceProvider
     */
    private $serviceProvider;
    /**
     * @var PopularityResult
     */
    private $popularityResult;


    /**
     * PopularityController constructor.
     */
    public function __construct(ServiceProvider $serviceProvider, PopularityResult $popularityResult)
    {
        $this->serviceProvider = $serviceProvider;
        $this->popularityResult = $popularityResult;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $term = request()->get('term');

        if ($term === null) {
            return $this->setStatusCode(422)->respond($this->transformValidationResponseData([]));
        }

        try {
            $termFromDb = $this->popularityResult->getResultBy($term);

            if ($termFromDb === null) {
                throw new NoTermInDbException;
            }

            return $this->setStatusCode(200)->respond($this->transformNormalDataResponse([
                'term' => $termFromDb->term,
                'score' => $termFromDb->score,
            ]));

        } catch (NoTermInDbException $e) {

            $result = [
                'term' => $term,
                'score' => $this->serviceProvider->getScore($term)
            ];

            $this->popularityResult->saveResultToDb($result);

            return $this->setStatusCode(200)->respond($this->transformNormalDataResponse($result));
        }
    }

    /**
     * @param $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data)
    {
        return response()->json($data, $this->getStatusCode(), $this->responseHeader);
    }
}
