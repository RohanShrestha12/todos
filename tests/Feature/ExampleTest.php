<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        // The application redirects from `/` to the todos index. Assert the
        // redirect target without following it so tests don't require DB.
        $response->assertStatus(302);
        $response->assertRedirect(route('todos.index'));
    }
}
