<?php

namespace App\Services;

abstract class ServiceProvider
{
    const POSITIVE_WORD_SULFIX = 'rocks';
    const NEGATIVE_WORD_SULFIX = 'sucks';

    public abstract function getResult($searchTerm);

    public abstract function getCount($result);

    public function getScore($word)
    {
        $positiveCount = $this->getCount($word . ' ' . self::POSITIVE_WORD_SULFIX);
        $negativeCount = $this->getCount($word . ' ' . self::NEGATIVE_WORD_SULFIX);

        return $positiveCount / ($positiveCount + $negativeCount) * 10;
    }
}