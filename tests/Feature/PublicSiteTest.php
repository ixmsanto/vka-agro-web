<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_renders_seeded_content(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Coco pith that')
            ->assertSee('Coco Peat 5 Kg Blocks')
            ->assertSee('Coco Husk Chips')
            ->assertSee('Plantation, Pollachi')
            ->assertSee('Martijn de Vries')
            ->assertSee('export@vkaagro.com');
    }

    public function test_contact_form_stores_an_inquiry(): void
    {
        $response = $this->post('/inquiry', [
            'name' => 'Jane Grower',
            'company' => 'Acme Farms',
            'email' => 'jane@example.com',
            'country' => 'Kenya',
            'message' => 'Need two containers of 5kg blocks.',
            'website' => '',
        ]);

        $response->assertRedirect(route('home').'#contact');
        $response->assertSessionHas('inquiry_sent', true);

        $this->assertDatabaseHas('inquiries', [
            'email' => 'jane@example.com',
            'name' => 'Jane Grower',
        ]);
    }

    public function test_contact_form_requires_name_and_email(): void
    {
        $this->post('/inquiry', ['website' => ''])
            ->assertSessionHasErrors(['name', 'email']);

        $this->assertSame(0, Inquiry::count());
    }

    public function test_contact_form_honeypot_blocks_bots(): void
    {
        $this->post('/inquiry', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'website' => 'http://spam.example',
        ])->assertSessionHasErrors('website');

        $this->assertSame(0, Inquiry::count());
    }
}
