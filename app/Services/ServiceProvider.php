<?php

namespace App\Services;

abstract class ServiceProvider
{
    const POSITIVE_WORD_SULFIX = 'rocks';
    const NEGATIVE_WORD_SULFIX = 'sucks';

    /**
     * Get result from service
     *
     * @param $searchTerm
     * @return mixed
     */
    public abstract function getResult($searchTerm);

    /**
     * Get number of results
     *
     * @param $result
     * @return mixed
     */
    public abstract function getCount($result);

    /**
     * Get score for word popularity
     *
     * @param $word
     * @return float|int
     */
    public function getScore($word)
    {
        $positiveCount = $this->getCount($this->getResult($word . ' ' . self::POSITIVE_WORD_SULFIX));
        $negativeCount = $this->getCount($this->getResult($word . ' ' . self::NEGATIVE_WORD_SULFIX));

        return $this->calucalteScore($positiveCount, $negativeCount);
    }

    /**
     * Calcultate score
     *
     * @param $positiveCount
     * @param $negativeCount
     * @return float|int
     */
    public function calucalteScore($positiveCount, $negativeCount)
    {
        if ($positiveCount == 0 && $negativeCount === 0) {
            return 0;
        }

        return number_format($positiveCount / ($positiveCount + $negativeCount) * 10, 2);
    }
}