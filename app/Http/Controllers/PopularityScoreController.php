<?php

namespace App\Http\Controllers;

use App\Exceptions\NoTermInDbException;
use App\PopularityResult;
use App\Services\ServiceProvider;
use Illuminate\Http\Request;

class PopularityScoreController extends Controller
{
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

        try {
            $resultFromDb = $this->popularityResult->getResultBy($term);

            if ($resultFromDb === null)
            {
                throw new NoTermInDbException;
            }

            return response()->json([
                'term' => $resultFromDb->term,
                'score' => $resultFromDb->score,
            ]);

        } catch (NoTermInDbException $e) {

            $result = [
                'term' => $term,
                'score' => $this->serviceProvider->getScore($term)
            ];

            $this->popularityResult->saveResultToDb($result);

            return response()->json($result);
        }
    }
}
