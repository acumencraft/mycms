<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\DomainSearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services')
    ->middleware('module:module_services');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio')
    ->middleware('module:module_portfolio');
Route::get('/blog', [PublicationController::class, 'index'])->name('blog')
    ->middleware('module:module_blog');
Route::get('/blog/{slug}', [PublicationController::class, 'show'])->name('blog.show')
    ->middleware('module:module_blog');
Route::get('/guides', [GuideController::class, 'index'])->name('guides')
    ->middleware('module:module_guides');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->name('guides.show')
    ->middleware('module:module_guides');
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
Route::middleware('auth')->group(function () {
    Route::get('/payment/{orderId}/create', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/payment/{orderId}/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/{orderId}/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
});

Route::post('/domain-search', [DomainSearchController::class, 'search'])->name('domain.search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/order', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/success/{orderId}', [OrderController::class, 'success'])->name('order.success');
});

Route::middleware(['auth','verified','client'])->prefix('client-dashboard')->name('client-dashboard.')->group(function () {
    Route::get('/', [ClientDashboardController::class, 'index'])->name('index');
    Route::get('/project/{id}', [ClientDashboardController::class, 'project'])->name('project');
    Route::post('/project/{projectId}/message', [ClientDashboardController::class, 'sendMessage'])->name('send-message');
    Route::post('/project/{projectId}/upload', [ClientDashboardController::class, 'uploadFile'])->name('upload-file');
    Route::get('/file/{fileId}/download', [ClientDashboardController::class, 'downloadFile'])->name('download-file');
    Route::get('/profile', [ClientDashboardController::class, 'editProfile'])->name('profile');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole(['Admin', 'Super Admin'])) {
        return redirect('/' . config('agency.admin_path', 'manage'));
    }

    if ($user->hasRole('Client')) {
        return redirect()->route('client-dashboard.index');
    }

    // Fallback: assign client role if user has no role
    $user->assignRole('Client');
    return redirect()->route('client-dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dynamic CMS Pages
Route::get('/page/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('page.show');

// Social Auth
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

// Shop
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/shop/{slug}/checkout', [App\Http\Controllers\ShopController::class, 'checkout'])->name('shop.checkout');
    Route::get('/shop/{slug}/success', [App\Http\Controllers\ShopController::class, 'checkoutSuccess'])->name('shop.checkout.success');
    Route::get('/shop/{slug}/cancel', [App\Http\Controllers\ShopController::class, 'checkoutCancel'])->name('shop.checkout.cancel');
    Route::get('/purchase/{purchase}/download', [App\Http\Controllers\ShopController::class, 'download'])->name('purchase.download');
});

Route::middleware(['module:module_shop'])->group(function () {
    Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');
});

Route::middleware(['auth', 'verified', 'module:module_shop'])->group(function () {
    Route::get('/shop/{slug}/checkout', [App\Http\Controllers\ShopController::class, 'checkout'])->name('shop.checkout');
    Route::get('/shop/{slug}/success', [App\Http\Controllers\ShopController::class, 'checkoutSuccess'])->name('shop.checkout.success');
    Route::get('/shop/{slug}/cancel', [App\Http\Controllers\ShopController::class, 'checkoutCancel'])->name('shop.checkout.cancel');
    Route::get('/purchase/{purchase}/download', [App\Http\Controllers\ShopController::class, 'download'])->name('purchase.download');
});

Route::get('/admin-test', function () {
    if (!auth()->check()) {
        return 'Not logged in';
    }
    $user = auth()->user();
    return [
        'id' => $user->id,
        'email' => $user->email,
        'roles' => $user->getRoleNames(),
        'status' => $user->status,
        'canAccess' => $user->canAccessPanel(app(\Filament\Panel::class)),
    ];
})->middleware('auth');

require __DIR__.'/auth.php';
Route::get('/testimonials', [App\Http\Controllers\TestimonialController::class, 'index'])->name('testimonials');
Route::post('/publications/{publication}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware(['auth', 'verified']);

Route::prefix('polls')->name('polls.')->group(function () {
    Route::get('/', [PollController::class, 'index'])->name('index');
    Route::get('/{id}', [PollController::class, 'show'])->name('show');
    Route::post('/{id}/vote', [PollController::class, 'vote'])->name('vote');
});

Route::middleware(['auth', 'verified', 'client'])->group(function () {
    Route::get('/subscribe', function () {
        $plans = \App\Models\SubscriptionPlan::where('is_active', true)->orderBy('sort')->get();
        $current = \App\Models\Subscription::where('user_id', auth()->id())
            ->whereIn('status', ['active', 'pending'])
            ->with('plan')
            ->first();
        return view('subscription.plans', compact('plans', 'current'));
    })->name('subscription.plans');
    Route::post('/subscribe/{plan}', function (\App\Models\SubscriptionPlan $plan) {
        $existing = \App\Models\Subscription::where('user_id', auth()->id())
            ->whereIn('status', ['active', 'pending'])
            ->first();
        if ($existing) {
            return back()->with('error', 'You already have an active subscription.');
        }
        $sub = \App\Models\Subscription::create([
            'user_id'              => auth()->id(),
            'subscription_plan_id' => $plan->id,
            'status'               => 'pending',
        ]);
        $sub->load(['user', 'plan']);
        \Illuminate\Support\Facades\Mail::to(config('agency.admin_email'))
            ->send(new \App\Mail\SubscriptionCancelAdminMail($sub));
        return redirect()->route('client-dashboard.index')
            ->with('success', 'Subscription request sent! We will activate it shortly.');
    })->name('subscription.request');
    Route::post('/subscription/cancel', function () {
        $sub = \App\Models\Subscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
        if ($sub) {
            $sub->update(['cancel_requested' => true]);
            $sub->load(['user', 'plan']);
            \Illuminate\Support\Facades\Mail::to($sub->user->email)
                ->send(new \App\Mail\SubscriptionCancelRequestMail($sub));
            \Illuminate\Support\Facades\Mail::to(config('agency.admin_email'))
                ->send(new \App\Mail\SubscriptionCancelAdminMail($sub));
        }
        return back()->with('success', 'Cancellation requested. We will contact you shortly.');
    })->name('subscription.cancel');
});
