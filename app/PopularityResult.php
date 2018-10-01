<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PopularityResult extends Model
{
    protected $table = 'popularity_results';

    /**
     * @param $term
     * @return Model|null|static
     */
    public function getResultBy($term)
    {
        return self::where('term', $term)->first();
    }

    /**
     * @param $result
     */
    public function saveResultToDb($result)
    {
        $resultFromDb = new self();
        $resultFromDb->term = $result['term'];
        $resultFromDb->score = $result['score'];
        $resultFromDb->save();
    }
}
