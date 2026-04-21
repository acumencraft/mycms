<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Fresh check from DB
        $user->unsetRelation('roles');
        
        if (!$user->hasAnyRole(['Admin', 'Super Admin', 'Editor', 'Support'])) {
            abort(403, 'Access denied. Role: ' . $user->getRoleNames()->implode(', '));
        }

        return $next($request);
    }
}
