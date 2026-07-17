<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $inquiry = Inquiry::create($request->safe()->except('website') + [
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        $this->notify($inquiry);

        return redirect()->to(route('home').'#contact')->with('inquiry_sent', true);
    }

    /**
     * Best-effort notification. The inquiry is already persisted, so a broken
     * SMTP config on shared hosting must never surface as a 500 to the visitor.
     */
    protected function notify(Inquiry $inquiry): void
    {
        $to = config('mail.inquiry_notify');

        if (! $to) {
            return;
        }

        try {
            Mail::raw($this->body($inquiry), function ($mail) use ($to, $inquiry) {
                $mail->to($to)
                    ->replyTo($inquiry->email, $inquiry->name)
                    ->subject('New export inquiry — '.$inquiry->name);
            });
        } catch (\Throwable $e) {
            Log::error('Inquiry notification failed', ['id' => $inquiry->id, 'error' => $e->getMessage()]);
        }
    }

    protected function body(Inquiry $inquiry): string
    {
        return implode("\n", [
            'Name:    '.$inquiry->name,
            'Company: '.($inquiry->company ?: '—'),
            'Email:   '.$inquiry->email,
            'Country: '.($inquiry->country ?: '—'),
            '',
            $inquiry->message ?: '(no message)',
        ]);
    }
}
