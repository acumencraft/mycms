<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403, 'Not authenticated');
        }

        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();
        
        $allowed = ['Super Admin', 'Admin', 'Editor', 'Support'];
        
        foreach ($allowed as $role) {
            if (in_array($role, $roles)) {
                return $next($request);
            }
        }

        abort(403, 'No permission. Roles: ' . implode(', ', $roles));
    }
}
