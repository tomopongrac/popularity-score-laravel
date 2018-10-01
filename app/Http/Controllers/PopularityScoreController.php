<?php

namespace App\Http\Controllers;

use App\Exceptions\jSonResponseNotExist;
use App\Exceptions\NoTermInDbException;
use App\PopularityResult;
use App\Responses\jSonResponseFactory;
use App\Services\ServiceProvider;

class PopularityScoreController extends Controller
{

    protected $statusCode;
    protected $responseHeader = [];
    protected $jsonResponse;
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
    public function show($version = null)
    {

        try {
            $this->jsonResponse = jSonResponseFactory::create($version);
        } catch (jSonResponseNotExist $e) {
            return $this->setStatusCode(404)->respond([]);
        }

        $term = request()->get('term');

        if ($term === null) {
            return $this->setStatusCode(422)->respond($this->jsonResponse->transformValidationResponseData([]));
        }

        try {
            $termFromDb = $this->popularityResult->getResultBy($term);

            if ($termFromDb === null) {
                throw new NoTermInDbException;
            }

            return $this->setStatusCode(200)->respond($this->jsonResponse->transformNormalDataResponse([
                'term' => $termFromDb->term,
                'score' => $termFromDb->score,
            ]));

        } catch (NoTermInDbException $e) {

            $result = [
                'term' => $term,
                'score' => $this->serviceProvider->getScore($term)
            ];

            $this->popularityResult->saveResultToDb($result);

            return $this->setStatusCode(200)->respond($this->jsonResponse->transformNormalDataResponse($result));
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
        $responseHeader = [];
        if ($this->jsonResponse !== null) {
            $responseHeader = $this->jsonResponse->getResponseHeader();
        }

        return response()->json($data, $this->getStatusCode(), $responseHeader);
    }

}
