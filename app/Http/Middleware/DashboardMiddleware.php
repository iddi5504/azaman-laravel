<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->checkIfFieldsAreFilled($request)) {
            return redirect()->route('profile.edit')->with(getFlashMessageObject('warning', 'Please fill out your profile', 'Make sure all fields are filled in to continue using Azanam'));
        }

        return $next($request);
    }

    function checkIfFieldsAreFilled(Request $request)
    {
        $user = $request->user();

        if (!$user->username || !$user->phone || !$user->profile_picture) {
            return false;
        }

        return true;
    }
}
