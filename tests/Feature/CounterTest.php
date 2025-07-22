<?php

namespace Tests\Feature;

use App\Models\Counter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_counter_index_page_displays_counter_value()
    {
        Counter::create(['count' => 5]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                ->has('count')
                ->where('count', 5)
        );
    }

    public function test_counter_index_creates_counter_if_none_exists()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                ->has('count')
                ->where('count', 0)
        );

        $this->assertDatabaseHas('counters', ['count' => 0]);
    }

    public function test_increment_increases_counter_value()
    {
        Counter::create(['count' => 5]);

        $response = $this->post('/', ['action' => 'increment']);

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                ->where('count', 6)
        );

        $this->assertDatabaseHas('counters', ['count' => 6]);
    }

    public function test_decrement_decreases_counter_value()
    {
        Counter::create(['count' => 5]);

        $response = $this->post('/', ['action' => 'decrement']);

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                ->where('count', 4)
        );

        $this->assertDatabaseHas('counters', ['count' => 4]);
    }

    public function test_counter_can_go_negative()
    {
        Counter::create(['count' => 0]);

        $response = $this->post('/', ['action' => 'decrement']);

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                ->where('count', -1)
        );

        $this->assertDatabaseHas('counters', ['count' => -1]);
    }

    public function test_invalid_action_defaults_to_increment()
    {
        Counter::create(['count' => 5]);

        $response = $this->post('/', ['action' => 'invalid']);

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                ->where('count', 5)
        );
    }

    public function test_no_action_defaults_to_increment()
    {
        Counter::create(['count' => 5]);

        $response = $this->post('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Counter')
                ->where('count', 6)
        );
    }
}