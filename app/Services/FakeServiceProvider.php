<?php

namespace App\Services;

class FakeServiceProvider extends ServiceProvider
{

    public function getResult($searchTerm)
    {
        if (strpos($searchTerm, self::POSITIVE_WORD_SULFIX) !== false)
        {
            return json_encode([
                "total_count" => 333
            ]);
        }

        return json_encode([
            "total_count" => 667
        ]);

    }

    public function getCount($result)
    {
        return json_decode($result)->total_count;
    }
}