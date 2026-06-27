<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\HelperService;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function __construct(private HelperService $helperService) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $ability, $table)
    {
        if ($redirect = $this->helperService->checkPermission($ability, $table)) {
            return $redirect;
        }

        return $next($request);
    }
}
