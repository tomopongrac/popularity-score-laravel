<?php

namespace Tests\Feature;

use App\PopularityResult;
use App\Services\FakeServiceProvider;
use App\Services\ServiceProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopularityTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function get_json_from_service_provider_and_save_to_db()
    {
        // Arange
        $serviceProvider = new FakeServiceProvider();
        $this->app->instance(ServiceProvider::class, $serviceProvider);

        // Act
        $this->get(route('score.show', ['term' => 'php']));

        // Assert
        $this->assertResponseStatus(200);
        $this->seeJsonSubset([
            'term' => 'php',
            'score' => 3.33
        ]);

        $this->seeInDatabase('popularity_results', [
            'term'         => 'php',
            'score'       => 3.33
        ]);
    }

    /** @test */
    public function get_json_from_db_if_it_exists_in_db()
    {
        // Arange
        $serviceProvider = new FakeServiceProvider();
        $this->app->instance(ServiceProvider::class, $serviceProvider);
        factory(PopularityResult::class)->create([
            'term' => 'php',
            'score' => 4.2
        ]);

        // Act
        $this->get(route('score.show', ['term' => 'php']));

        // Assert
        $this->assertResponseStatus(200);
        $this->seeJsonSubset([
            'term' => 'php',
            'score' => 4.2
        ]);
        $termsCount = PopularityResult::all()->count();
        $this->assertEquals(1, $termsCount);
    }


}
