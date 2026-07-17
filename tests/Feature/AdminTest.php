<?php

namespace Tests\Feature;

use App\Models\GalleryItem;
use App\Models\Medium;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::firstWhere('username', 'admin');
    }

    public function test_admin_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_login_with_correct_credentials(): void
    {
        $this->post(route('admin.login'), [
            'username' => 'admin',
            'password' => 'vka@2026',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_login_rejects_wrong_password(): void
    {
        $this->from(route('admin.login'))->post(route('admin.login'), [
            'username' => 'admin',
            'password' => 'wrong',
        ])->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_login_accepts_email_as_username(): void
    {
        $this->post(route('admin.login'), [
            'username' => 'export@vkaagro.com',
            'password' => 'vka@2026',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_setting_autosave_updates_group(): void
    {
        $this->actingAs($this->admin)
            ->putJson(route('admin.settings.update', 'hero'), ['titleAccent' => 'grows stronger'])
            ->assertOk()
            ->assertJson(['saved' => true]);

        $this->assertSame('grows stronger', Setting::group('hero')['titleAccent']);
        // A partial write must leave the other keys intact.
        $this->assertSame('Coco pith that', Setting::group('hero')['titleLine1']);
    }

    public function test_setting_ignores_unknown_field(): void
    {
        // Unknown keys are dropped by validation, never persisted.
        $this->actingAs($this->admin)
            ->putJson(route('admin.settings.update', 'hero'), ['evil' => 'x'])
            ->assertOk();

        $this->assertArrayNotHasKey('evil', Setting::group('hero'));
    }

    public function test_setting_validates_email_and_length(): void
    {
        $this->actingAs($this->admin)
            ->putJson(route('admin.settings.update', 'contact'), ['email' => 'not-an-email'])
            ->assertStatus(422);

        $this->actingAs($this->admin)
            ->putJson(route('admin.settings.update', 'hero'), ['badge' => str_repeat('a', 500)])
            ->assertStatus(422);
    }

    public function test_collection_field_autosave_is_whitelisted(): void
    {
        $product = Product::ordered()->first();

        $this->actingAs($this->admin)
            ->patchJson(route('admin.collection.update', ['products', $product->id]), [
                'field' => 'title',
                'value' => 'Renamed Blocks',
            ])->assertOk();

        $this->assertSame('Renamed Blocks', $product->fresh()->title);

        // image_path is not editable through the autosave endpoint.
        $this->actingAs($this->admin)
            ->patchJson(route('admin.collection.update', ['products', $product->id]), [
                'field' => 'image_path',
                'value' => '../../etc/passwd',
            ])->assertStatus(422);
    }

    public function test_add_and_delete_product(): void
    {
        $before = Product::count();

        $this->actingAs($this->admin)
            ->post(route('admin.collection.store', 'products'))
            ->assertRedirect();

        $this->assertSame($before + 1, Product::count());

        $new = Product::ordered()->get()->last();

        $this->actingAs($this->admin)
            ->delete(route('admin.collection.destroy', ['products', $new->id]))
            ->assertRedirect();

        $this->assertSame($before, Product::count());
    }

    public function test_reorder_swaps_positions(): void
    {
        [$first, $second] = Product::ordered()->take(2)->get()->all();

        $this->actingAs($this->admin)
            ->post(route('admin.collection.move', ['products', $first->id]), ['direction' => 'down'])
            ->assertRedirect();

        $this->assertTrue($first->fresh()->position > $second->fresh()->position);
    }

    public function test_image_upload_to_gallery_tile(): void
    {
        Storage::fake('uploads');
        $tile = GalleryItem::ordered()->first();

        $this->actingAs($this->admin)
            ->post(route('admin.collection.image', ['gallery', $tile->id]), [
                'image' => UploadedFile::fake()->image('tile.jpg', 800, 600),
            ])->assertRedirect();

        $path = $tile->fresh()->image_path;
        $this->assertNotNull($path);
        Storage::disk('uploads')->assertExists($path);
    }

    public function test_image_upload_rejects_php_file(): void
    {
        Storage::fake('uploads');
        $tile = GalleryItem::ordered()->first();

        $this->actingAs($this->admin)
            ->from(route('admin.collection.index', 'gallery'))
            ->post(route('admin.collection.image', ['gallery', $tile->id]), [
                'image' => UploadedFile::fake()->create('evil.php', 10, 'application/x-php'),
            ])->assertSessionHasErrors('image');

        $this->assertNull($tile->fresh()->image_path);
    }

    public function test_media_slot_upload_and_clear(): void
    {
        Storage::fake('uploads');

        $this->actingAs($this->admin)
            ->post(route('admin.media.store', 'logo'), [
                'file' => UploadedFile::fake()->image('logo.png', 240, 80),
            ])->assertRedirect();

        $this->assertNotNull(Medium::firstWhere('slot', 'logo'));

        $this->actingAs($this->admin)
            ->delete(route('admin.media.destroy', 'logo'))
            ->assertRedirect();

        $this->assertNull(Medium::firstWhere('slot', 'logo'));
    }

    public function test_unknown_collection_is_404(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/widgets')
            ->assertNotFound();
    }
}
