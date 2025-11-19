<?php

namespace Tapp\FilamentHelp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware that allows all users (authenticated and unauthenticated) to access public help articles.
 * The controller will handle redirecting authenticated users to the authenticated help route.
 */
class AllowPublicHelpAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow all users - no authentication required
        // The controller will redirect authenticated users to the authenticated help route
        return $next($request);
    }
}


