<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Shared\App\Support\Permissions\PlatformTeam;
use Symfony\Component\HttpFoundation\Response;

class SetPlatformPermissionsTeam
{
    public function handle(Request $request, Closure $next): Response
    {
        PlatformTeam::activate();

        return $next($request);
    }
}