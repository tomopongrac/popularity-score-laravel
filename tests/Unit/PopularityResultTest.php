<?php

namespace Tests\Unit;

use App\PopularityResult;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopularityResultTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function get_result_by_term()
    {
        // Arrange
        $resultA = factory(PopularityResult::class)->create([
            'term' => 'php',
            'score' => 4.2
        ]);
        factory(PopularityResult::class)->create([
            'term' => 'javaScript',
            'score' => 3
        ]);

        // Act
        $result = (new PopularityResult())->getResultBy('php');

        // Assert
        $this->assertEquals($result->term, $resultA->term);
    }

    /** @test */
    public function saveResultToDb()
    {
        // Act
        $data = [
            'term' => 'php',
            'score' => 4.2
        ];
        (new PopularityResult())->saveResultToDb($data);

        // Assert
        $this->seeInDatabase('popularity_results', [
            'term' => 'php',
            'score' => 4.2
        ]);
    }
}
