<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\SiteContent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Idempotent: every section bails if it already has rows, so re-running
     * the seeder on a live deploy never duplicates or clobbers edited content.
     */
    public function run(): void
    {
        $this->admin();
        $this->settings();
        $this->products();
        $this->gallery();
        $this->testimonials();
        $this->posts();

        SiteContent::flush();
    }

    protected function admin(): void
    {
        $username = env('ADMIN_USERNAME', 'admin');

        User::updateOrCreate(
            ['username' => $username],
            [
                'name' => 'Admin',
                'email' => env('ADMIN_EMAIL', 'export@vkaagro.com'),
                'password' => env('ADMIN_PASSWORD', 'vka@2026'),
            ],
        );
    }

    protected function settings(): void
    {
        foreach (Setting::defaults() as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    protected function products(): void
    {
        if (Product::query()->exists()) {
            return;
        }

        $products = [
            [
                'num' => '01',
                'tag' => 'Bulk media',
                'title' => 'Coco Peat 5 Kg Blocks',
                'image_placeholder' => 'Coco peat 5 KG block — product shot on white',
                'description' => 'Weighing 4.8–5.2 kg, a single block reconstitutes with roughly 25 litres of water to yield 60–75 litres of growing media. Packed in pallets or bales of five, they are used in bulk for potting soil and soil-less cultivation — available as Washed Low EC and Unwashed High EC.',
                'specs' => [
                    ['Weight', '4.8 – 5.2 kg'],
                    ['Expands to', '60 – 75 litres'],
                    ['Quality', 'Washed / Unwashed'],
                    ['Packing', 'Pallet · Bale of 5'],
                ],
            ],
            [
                'num' => '02',
                'tag' => 'Retail & home',
                'title' => 'Coco Coir Briquettes',
                'image_placeholder' => 'Coco coir briquettes — 650g bricks',
                'description' => 'Palm-sized 650 g briquettes expand to 8–9 litres with warm water. Low-dust and easy to ship, they are ideal for retail packs, seed starting and home gardening — buffered and washed to a stable, low EC.',
                'specs' => [
                    ['Weight', '600 – 650 g'],
                    ['Expands to', '8 – 9 litres'],
                    ['EC', '< 0.5 mS/cm'],
                    ['Packing', 'Cartons of 20–30'],
                ],
            ],
            [
                'num' => '03',
                'tag' => 'Hydroponics',
                'title' => 'Coco Coir Grow Bags',
                'image_placeholder' => 'Coco coir grow bags in a greenhouse',
                'description' => 'Open-top bags pre-filled with buffered coco pith or a pith-and-chip blend, engineered for tomato, cucumber, pepper and berry crops in controlled greenhouses. Drainage slits and a consistent air-to-water ratio keep roots healthy across the season.',
                'specs' => [
                    ['Size', '100 × 15 × 15 cm'],
                    ['Media', 'Pith / Chip mix'],
                    ['EC', 'Buffered < 0.8'],
                    ['Best for', 'Fruiting crops'],
                ],
            ],
            [
                'num' => '04',
                'tag' => 'High aeration',
                'title' => 'Coco Husk Chips',
                'image_placeholder' => 'Coco husk chips — graded',
                'description' => 'Graded coconut husk chips deliver high aeration and long structural life for orchids, anthuriums and long-cycle crops. Washed to a low EC and offered in grades from fine to chunky, compressed into convenient 5 kg blocks.',
                'specs' => [
                    ['Grade', 'Fine – Chunky'],
                    ['Expands to', '60 – 70 litres'],
                    ['EC', 'Washed Low'],
                    ['Packing', '5 kg block'],
                ],
            ],
        ];

        foreach ($products as $i => $data) {
            $specs = $data['specs'];
            unset($data['specs']);

            $product = Product::create($data + ['position' => $i + 1]);

            foreach ($specs as $j => [$label, $value]) {
                $product->specs()->create([
                    'position' => $j + 1,
                    'label' => $label,
                    'value' => $value,
                ]);
            }
        }

        // The only real product photo recovered from the design project.
        $this->seedAsset(Product::where('num', '01')->first(), 'coco-peat-block.webp');
    }

    /** Copy a bundled asset into public/uploads and point a row at it. */
    protected function seedAsset(?object $model, string $asset): void
    {
        $source = database_path('seeders/assets/'.$asset);

        if (! $model || ! is_file($source)) {
            return;
        }

        $dir = public_path('uploads');

        if (! is_dir($dir)) {
            mkdir($dir, 0o755, true);
        }

        copy($source, $dir.'/'.$asset);
        $model->update(['image_path' => $asset]);
    }

    protected function gallery(): void
    {
        if (GalleryItem::query()->exists()) {
            return;
        }

        $tiles = [
            ['Plantation, Pollachi', 2, 2],
            ['5 Kg blocks', 1, 1],
            ['Buffered pith', 1, 2],
            ['Quality lab', 1, 1],
            ['Grow bags in production', 2, 1],
            ['Raw husk', 1, 1],
            ['Container loading', 1, 1],
        ];

        foreach ($tiles as $i => [$caption, $col, $row]) {
            GalleryItem::create([
                'position' => $i + 1,
                'caption' => $caption,
                'col_span' => $col,
                'row_span' => $row,
            ]);
        }
    }

    protected function testimonials(): void
    {
        if (Testimonial::query()->exists()) {
            return;
        }

        $items = [
            ['The EC is exactly what the certificate says, batch after batch. Our propagation losses dropped noticeably after switching to VKA.', 'Martijn de Vries', 'Greenhouse grower · Netherlands'],
            ['Containers arrive on schedule with clean documentation. As a distributor, that reliability is worth as much as the product itself.', 'Khalid Al-Farsi', 'Horticulture distributor · UAE'],
            ['Their grow bags gave us a uniform air-to-water ratio across the whole tunnel. Our berry yields have been the best in years.', 'Lucía Fernández', 'Berry nursery · Spain'],
        ];

        foreach ($items as $i => [$quote, $name, $role]) {
            Testimonial::create([
                'position' => $i + 1,
                'quote' => $quote,
                'name' => $name,
                'role' => $role,
            ]);
        }
    }

    protected function posts(): void
    {
        if (Post::query()->exists()) {
            return;
        }

        $items = [
            ['Guides', '6 min read', 'Washed vs unwashed coco peat: choosing the right EC', "When low EC matters, when it doesn't, and how buffering changes the picture."],
            ['How-to', '4 min read', 'How to hydrate a 5 kg block the right way', 'Water ratios, timing and fluffing tips to hit a full 70–75 litres every time.'],
            ['Hydroponics', '7 min read', 'Setting up coir grow bags for fruiting crops', 'Drippers, drainage slits and steering strategy for tomato and berry tunnels.'],
        ];

        foreach ($items as $i => [$category, $readTime, $title, $excerpt]) {
            Post::create([
                'position' => $i + 1,
                'category' => $category,
                'read_time' => $readTime,
                'title' => $title,
                'excerpt' => $excerpt,
            ]);
        }
    }
}
