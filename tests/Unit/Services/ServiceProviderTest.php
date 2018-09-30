<?php

namespace Tests\Unit;

use App\Services\GitHubServiceProvider;
use Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function score_have_two_decimal_points()
    {
        // Arrange
        $gitHubServiceProvider = new GitHubServiceProvider();
        $positiveCount = 2414;
        $negativeCount = 4546;

        // Act
        $score = $gitHubServiceProvider->calucalteScore($positiveCount, $negativeCount);

        // Assert
        $this->assertEquals(3.47, $score);
    }

    /** @test */
    public function if_positive_and_negative_count_is_zero_score_is_also_zero()
    {
        // Arrange
        $gitHubServiceProvider = new GitHubServiceProvider();
        $positiveCount = 0;
        $negativeCount = 0;

        // Act
        $score = $gitHubServiceProvider->calucalteScore($positiveCount, $negativeCount);

        // Assert
        $this->assertEquals(0, $score);
    }
}
