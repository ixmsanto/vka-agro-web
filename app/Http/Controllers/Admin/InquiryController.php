<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(): View
    {
        $inquiries = Inquiry::latest()->paginate(20);

        // Viewing the list is the read receipt.
        Inquiry::whereNull('read_at')->update(['read_at' => now()]);

        return view('admin.inquiries', ['inquiries' => $inquiries]);
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return back()->with('status', 'Inquiry deleted.');
    }
}
