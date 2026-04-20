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

Route::get('/order', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{orderId}', [OrderController::class, 'success'])->name('order.success');

Route::middleware(['auth', 'client'])->prefix('client-dashboard')->name('client-dashboard.')->group(function () {
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
        return redirect('/admin');
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

require __DIR__.'/auth.php';
Route::get('/testimonials', [App\Http\Controllers\TestimonialController::class, 'index'])->name('testimonials');
Route::post('/publications/{publication}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::prefix('polls')->name('polls.')->group(function () {
    Route::get('/', [PollController::class, 'index'])->name('index');
    Route::get('/{id}', [PollController::class, 'show'])->name('show');
    Route::post('/{id}/vote', [PollController::class, 'vote'])->name('vote');
});
