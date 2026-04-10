<?php
namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\MenuItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Models\Publication;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Feature;
use App\Observers\OrderObserver;
use App\Observers\PublicationObserver;
use App\Observers\PortfolioProjectObserver;
use App\Observers\GuideObserver;
use App\Models\Guide;
use App\Models\PortfolioProject;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Order::observe(OrderObserver::class);
        Publication::observe(PublicationObserver::class);
        PortfolioProject::observe(PortfolioProjectObserver::class);
        Guide::observe(GuideObserver::class);

        Service::saved(fn() => Cache::forget('home.services'));
        Service::deleted(fn() => Cache::forget('home.services'));
        Testimonial::saved(fn() => Cache::forget('home.testimonials'));
        Testimonial::deleted(fn() => Cache::forget('home.testimonials'));
        Feature::saved(fn() => Cache::forget('home.features'));
        Feature::deleted(fn() => Cache::forget('home.features'));
        SiteSetting::saved(fn() => Cache::forget('site.settings'));
        MenuItem::saved(fn() => Cache::forget('menu.items'));
        MenuItem::deleted(fn() => Cache::forget('menu.items'));

        Event::listen(Login::class, LogSuccessfulLogin::class);

        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()
                ->numbers();
        });

        // Filament admin routes-ზე composer არ გაეშვება
        View::composer('*', function ($view) {
            if (Request::is('admin*')) {
                return;
            }

            $siteSettings = Cache::remember('site.settings', 3600, function () {
                return SiteSetting::pluck('value', 'key')->toArray();
            });

            $menuItems = Cache::remember('menu.items', 3600, function () {
                return MenuItem::all();
            });

            $view->with('siteSettings', $siteSettings);
            $view->with('headerMenuItems', $menuItems->where('location', 'header')->values());
            $view->with('footerMenuItems', $menuItems->where('location', 'footer')->values());
            $view->with('bottomMenuItems', $menuItems->where('location', 'bottom')->values());
        });
    }
}
