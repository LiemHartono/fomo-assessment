<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRaceConditionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_handle_race_condition_during_flash_sale()
    {
        $product = Product::create([
            'name' => 'Flash Sale Phone',
            'price' => 1000000,
            'stock' => 10,
        ]);

        for ($i = 0; $i < 20; $i++) {
            $response = $this->postJson('/api/orders', [
                'product_id' => $product->id,
                'quantity' => 1,
            ]);

        }

        $product->refresh();

        $this->assertGreaterThanOrEqual(0, $product->stock);

        $this->assertEquals(0, $product->stock);

        $this->assertDatabaseCount('orders', 10);
    }
}
