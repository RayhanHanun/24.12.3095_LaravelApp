<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventPosterTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->category = Category::create([
            'name' => 'Seminar',
            'slug' => 'seminar',
        ]);
    }

    public function test_event_form_rejects_invalid_price_stock_and_poster(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), [
            ...$this->validEventData(),
            'price' => -1,
            'stock' => 0,
            'poster' => UploadedFile::fake()->create('poster.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors(['price', 'stock', 'poster']);
        $this->assertDatabaseCount('events', 0);
    }

    public function test_admin_can_store_event_with_poster(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), [
            ...$this->validEventData(),
            'poster' => UploadedFile::fake()->image('poster.jpg')->size(1024),
        ]);

        $response->assertRedirect(route('admin.events.index'));

        $event = Event::firstOrFail();

        $this->assertNotNull($event->poster_path);
        Storage::disk('public')->assertExists($event->poster_path);
    }

    public function test_event_form_rejects_poster_larger_than_two_megabytes(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), [
            ...$this->validEventData(),
            'poster' => UploadedFile::fake()->image('poster.jpg')->size(2049),
        ]);

        $response->assertSessionHasErrors(['poster']);
        $this->assertDatabaseCount('events', 0);
    }

    public function test_update_without_new_poster_keeps_existing_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posters/old.jpg', 'old poster');

        $event = Event::create([
            ...$this->validEventData(),
            'poster_path' => 'posters/old.jpg',
        ]);

        $this->actingAs($this->admin)
            ->put(route('admin.events.update', $event), [
                ...$this->validEventData(),
                'title' => 'Judul Diperbarui',
            ])
            ->assertRedirect(route('admin.events.index'));

        $this->assertSame('posters/old.jpg', $event->fresh()->poster_path);
        Storage::disk('public')->assertExists('posters/old.jpg');
    }

    public function test_update_with_new_poster_deletes_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posters/old.jpg', 'old poster');

        $event = Event::create([
            ...$this->validEventData(),
            'poster_path' => 'posters/old.jpg',
        ]);

        $this->actingAs($this->admin)
            ->put(route('admin.events.update', $event), [
                ...$this->validEventData(),
                'poster' => UploadedFile::fake()->image('new-poster.jpg')->size(1024),
            ])
            ->assertRedirect(route('admin.events.index'));

        $newPosterPath = $event->fresh()->poster_path;

        $this->assertNotSame('posters/old.jpg', $newPosterPath);
        Storage::disk('public')->assertMissing('posters/old.jpg');
        Storage::disk('public')->assertExists($newPosterPath);
    }

    public function test_destroy_deletes_event_poster_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posters/event.jpg', 'event poster');

        $event = Event::create([
            ...$this->validEventData(),
            'poster_path' => 'posters/event.jpg',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.events.destroy', $event))
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        Storage::disk('public')->assertMissing('posters/event.jpg');
    }

    public function test_public_detail_displays_selected_event(): void
    {
        $event = Event::create([
            ...$this->validEventData(),
            'title' => 'Event Dinamis Amikom',
        ]);

        $this->get(route('events.show', $event))
            ->assertOk()
            ->assertSee('Event Dinamis Amikom')
            ->assertSee($event->location);
    }

    public function test_changed_event_pages_render_successfully(): void
    {
        Storage::fake('public');

        $event = Event::create($this->validEventData());

        $this->actingAs($this->admin)
            ->get(route('admin.events.index'))
            ->assertOk();

        $this->get(route('admin.events.create'))
            ->assertOk();

        $this->get(route('admin.events.edit', $event))
            ->assertOk();

        $this->get(route('welcome'))
            ->assertOk();

        $this->get(route('checkout.event', $event))
            ->assertOk()
            ->assertSee($event->title);
    }

    private function validEventData(): array
    {
        return [
            'category_id' => $this->category->id,
            'title' => 'Workshop Laravel',
            'description' => 'Belajar validation dan file upload.',
            'date' => now()->addWeek()->format('Y-m-d H:i:s'),
            'location' => 'Universitas Amikom Yogyakarta',
            'price' => 50000,
            'stock' => 25,
        ];
    }
}
