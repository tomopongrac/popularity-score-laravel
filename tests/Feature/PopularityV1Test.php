<?php

namespace Tests\Feature;

use App\PopularityResult;
use App\Services\FakeServiceProvider;
use App\Services\ServiceProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopularityV1Test extends TestCase
{

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->serviceProvider = new FakeServiceProvider();
        $this->app->instance(ServiceProvider::class, $this->serviceProvider);
    }

    /** @test */
    public function get_json_from_service_provider_and_save_to_db()
    {
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

    /** @test */
    public function term_is_required_parametar()
    {
        // Act
        $this->get(route('score.show'));

        // Assert
        $this->assertResponseStatus(422);
    }

    /** @test */
    public function term_must_have_word()
    {
        // Act
        $this->get(route('score.show', ['term' => '']));

        // Assert
        $this->assertResponseStatus(422);
    }

}
