<?php
namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleEnabled
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $settings = Cache::remember('site.settings', 3600, function () {
            return SiteSetting::pluck('value', 'key')->toArray();
        });

        // თუ setting არ არსებობს — default true (ჩართულია)
        $isEnabled = $settings[$module] ?? true;

        if (!$isEnabled || $isEnabled === '0' || $isEnabled === false) {
            abort(404);
        }

        return $next($request);
    }
}
