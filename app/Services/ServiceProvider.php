<?php

namespace App\Services;

abstract class ServiceProvider
{
    protected $positiveCount;

    protected $negativeCount;

    public abstract function getResult($word, $sulfix);

    public abstract function getCount($result);

    public function getScore($word)
    {
        $positiveCount = $this->getPositiveCount($word);
        $negativeCount = $this->getNegativeCount($word);

        return $positiveCount / ($positiveCount + $negativeCount) * 10;
    }
}