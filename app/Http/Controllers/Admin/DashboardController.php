<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\Inquiry;
use App\Models\Post;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['route' => route('admin.collection.index', 'products'), 'label' => 'Products', 'count' => Product::count(), 'hint' => 'Blocks, briquettes, grow bags, chips'],
                ['route' => route('admin.collection.index', 'blog'), 'label' => 'Articles', 'count' => Post::count(), 'hint' => 'Guides shown on the home page'],
                ['route' => route('admin.collection.index', 'gallery'), 'label' => 'Gallery tiles', 'count' => GalleryItem::count(), 'hint' => 'Bento grid on the site'],
                ['route' => route('admin.collection.index', 'testimonials'), 'label' => 'Testimonials', 'count' => Testimonial::count(), 'hint' => 'Grower quotes'],
                ['route' => route('admin.inquiries.index'), 'label' => 'Inquiries', 'count' => Inquiry::count(), 'hint' => 'Contact-form submissions'],
            ],
            'unread' => Inquiry::whereNull('read_at')->count(),
        ]);
    }
}
