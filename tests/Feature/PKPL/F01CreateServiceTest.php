<?php

namespace Tests\Feature\PKPL;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class F01CreateServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Notification::fake();
        Http::preventStrayRequests();
        Storage::fake('public');
        // Also clean the fake disk if an assertion fails.
        $this->beforeApplicationDestroyed(fn () => Storage::disk('public')->deleteDirectory('products'));
    }

    private function nativeServicePayload(): array
    {
        // The form hides stock without disabling it and unchecks condition radios.
        return [
            'name' => 'PKPL Service: Website Consultation',
            'description' => 'One hour of website consultation for university students.',
            'price' => 50000,
            'category' => 'Service',
            'stock' => '',
            'image_urls' => [UploadedFile::fake()->image('service.jpg', 100, 100)],
        ];
    }

    public function test_characterization_native_service_payload_is_rejected_by_current_validation(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->assertTrue($user->hasVerifiedEmail());

        $response = $this->actingAs($user)
            ->from(route('product.create'))
            ->post(route('product.post'), $this->nativeServicePayload());

        $response->assertRedirect(route('product.create'));
        $response->assertSessionHasErrors(['stock', 'condition']);
        $this->assertEqualsCanonicalizing(['stock', 'condition'], array_keys(session('errors')->getBag('default')->messages()));
        $this->assertDatabaseCount('products', 0);
        $this->assertDatabaseCount('product_images', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
        Mail::assertNothingSent();
        Notification::assertNothingSent();
    }

    public function test_acceptance_service_can_be_created_without_applicable_stock_and_condition(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->assertTrue($user->hasVerifiedEmail());
        $payload = $this->nativeServicePayload();

        $response = $this->actingAs($user)
            ->from(route('product.create'))
            ->post(route('product.post'), $payload);

        // Deliberately fails until the production feature meets the requirement.
        $response->assertSessionDoesntHaveErrors(['stock', 'condition']);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('product.index', ['view_type' => 'home']));
        $this->assertDatabaseHas('products', [
            'name' => $payload['name'],
            'category' => 'Service',
            'stock' => null,
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseCount('products', 1);
        $product = Product::where('name', $payload['name'])->sole();
        $this->assertDatabaseCount('product_images', 1);
        $image = $product->images()->sole();
        $this->assertDatabaseHas('product_images', ['product_id' => $product->id, 'image_url' => $image->image_url]);
        Storage::disk('public')->assertExists([$product->image_url, $image->image_url]);
        Mail::assertNothingSent();
        Notification::assertNothingSent();
        // No condition value is asserted: its Service representation is not formalized.
    }
}
