<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckClientRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account is not active.']);
        }

        if (!$user->hasRole('Client')) {
            abort(403, 'Access denied. Client role required.');
        }

        return $next($request);
    }
}
