<?php

namespace Tests\Unit;

use App\Services\GitHubServiceProvider;
use Tests\TestCase;

class GitHubServiceProviderTest extends TestCase
{

    /** @test */
    public function json_result_must_have_field_total_count()
    {
        // Act
        $gitHubResult = (new GitHubServiceProvider())->getResult('php rocks');

        // Assert
        $this->assertTrue(property_exists(json_decode($gitHubResult), 'total_count'));
    }

    /** @test */
    public function get_total_count_value_from_json_result()
    {
        // Arrange
        $jsonResult = json_encode(['total_count' => 7]);

        // Act
        $resultCount = (new GitHubServiceProvider())->getCount($jsonResult);

        // Assert
        $this->assertEquals(7, $resultCount);
    }
}
