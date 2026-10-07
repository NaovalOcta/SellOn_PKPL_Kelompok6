<?php
// tests/Feature/ProductDeletionTest.php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductDeletionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_deletes_the_product_and_its_image_file()
    {
        // -------------------------------------------------
        // Fake the public disk – no real files are written
        // -------------------------------------------------
        Storage::fake('public');

        // -------------------------------------------------
        // Create a product that “has an image”
        // -------------------------------------------------
        $imageName = $this->faker->slug . '.jpg';
        // put a dummy file where the controller expects it:
        Storage::disk('public')->put('products/' . $imageName, 'dummy content');

        $product = Product::factory()->create([
            'image_url' => $imageName,          // <-- column used in destroy()
        ]);

        // -------------------------------------------------
        // Call the controller action directly
        // -------------------------------------------------
        $controller = new ProductController();

        // The method expects the product id as a route‑parameter:
        $response = $controller->destroy($product->id);

        // -------------------------------------------------
        // Assertions
        // -------------------------------------------------
        // 4.1 The file should be gone
        Storage::disk('public')->assertMissing('products/' . $imageName);

        // 4.2 The DB record should be removed
        $this->assertDatabaseMissing('products', ['id' => $product->id]);

        // 4.3 (Optional) The redirect response
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect(route('users.my-products'));
    }
}
