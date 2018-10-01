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

    protected function setUp()
    {
        parent::setUp();
        $this->serviceProvider = new FakeServiceProvider();
        $this->app->instance(ServiceProvider::class, $this->serviceProvider);
    }

    /** @test */
    public function if_vesion_not_exists_return_404()
    {
        $this->disableExceptionHandling();
        // Act
        $this->get(route('score.v2.show', ['term' => 'php', 'version' => 3]));

        // Assert
        $this->assertResponseStatus(404);

        $this->dontSeeInDatabase('popularity_results', [
            'term'         => 'php',
        ]);
    }

}
