<?php

namespace App\Services;

class FakeServiceProvider extends ServiceProvider
{

    public function getResult($words, $sulfix)
    {
        if ($sulfix === 'rocks')
        {
            return json_encode([
                "total_count" => 333
            ]);
        }

        return json_encode([
            "total_count" => 667
        ]);

    }

    public function getPositiveCount($word)
    {
        $result = $this->getResult($word, 'rocks');

        return $this->getCount($result);
    }

    public function getNegativeCount($word)
    {
        $result = $this->getResult($word, 'sucks');

        return $this->getCount($result);
    }

    public function getCount($result)
    {
        return json_decode($result)->total_count;
    }
}