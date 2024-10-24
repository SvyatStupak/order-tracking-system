<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /** @test */
    public function it_creates_an_order()
    {
        $data = [
            'product_name' => 'Test Product',
            'amount' => 99.99,
        ];

        $response = $this->postJson('/api/orders', $data);

        $response->assertStatus(201)
            ->assertJson([
                'product_name' => 'Test Product',
                'amount' => 99.99,
            ]);
    }

    /** @test */
    public function it_shows_an_order()
    {
        $order = Order::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $order->id,
                'product_name' => $order->product_name,
            ]);
    }

    /** @test */
    public function it_updates_an_order()
    {
        $order = Order::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $data = [
            'status' => 'shipped',
        ];

        $response = $this->putJson("/api/orders/{$order->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'shipped',
            ]);
    }

    /** @test */
    public function it_deletes_an_order()
    {
        $order = Order::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response->assertStatus(204);
    }
}
