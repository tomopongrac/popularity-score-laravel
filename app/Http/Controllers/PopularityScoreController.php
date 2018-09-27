<?php

namespace App\Http\Controllers;

use App\Exceptions\NoResultException;
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
     * PopularityController constructor.
     */
    public function __construct(ServiceProvider $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
    }

    public function show()
    {
        $term = request()->get('term');

        try {
            $popularityResult = PopularityResult::where('term', $term)->first();

            if ($popularityResult === null)
            {
                throw new NoResultException;
            }

            return response()->json([
                'term' => $popularityResult->term,
                'score' => $popularityResult->score,
            ]);

        } catch (NoResultException $e) {
            $popularityResult = new PopularityResult();
            $popularityResult->term = $term;
            $popularityResult->score = $this->serviceProvider->getScore(request()->get('term'));
            $popularityResult->save();

            return response()->json([
                'term' => request()->get('term'),
                'score' => $this->serviceProvider->getScore(request()->get('term'))
            ]);
        }
    }
}
