<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class ResolveTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Determine tenant from subdomain or header
        $slug = $request->header('X-Tenant-ID') ?: Str::before($request->getHost(), '.dineflow.local'); // eg: demo.dineflow.local

        $tenant = $slug ? Tenant::where('slug', $slug)->first() : null;

        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found'], 404);
        }

        // Bind globally for this request
        app()->instance(Tenant::class, $tenant);

        // Share on request for convenience
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
