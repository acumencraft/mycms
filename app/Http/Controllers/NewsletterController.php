<?php
namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Mail\NewsletterWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'name'  => 'nullable|string|max:255',
        ]);

        $existing = NewsletterSubscriber::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->status === 'unsubscribed') {
                $existing->update(['status' => 'active']);
                Mail::to($existing->email)->send(new NewsletterWelcomeMail($existing));
            }
            return back()->with('newsletter_success', 'You are already subscribed. Welcome back!');
        }

        $subscriber = NewsletterSubscriber::create([
            'email'  => $request->email,
            'name'   => $request->name,
            'status' => 'active',
        ]);

        Mail::to($subscriber->email)->send(new NewsletterWelcomeMail($subscriber));

        return back()->with('newsletter_success', 'Thank you for subscribing!');
    }

    public function unsubscribe(string $token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->firstOrFail();
        $subscriber->update(['status' => 'unsubscribed']);

        return view('newsletter.unsubscribed', compact('subscriber'));
    }
}
