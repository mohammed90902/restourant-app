<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Convert role names to role IDs if strings are passed
        $allowedRoles = array_map(function($role) {
            return match($role) {
                'admin' => User::ROLE_ADMIN,
                'waiter' => User::ROLE_WAITER,
                'chef' => User::ROLE_CHEF,
                'customer' => User::ROLE_CUSTOMER,
                default => (int) $role
            };
        }, $roles);

        if (!in_array($request->user()->role, $allowedRoles)) {
            // Redirect to appropriate dashboard based on user role
            return $this->redirectToDashboard($request->user());
        }

        return $next($request);
    }

    /**
     * Redirect user to their appropriate dashboard
     */
    protected function redirectToDashboard($user): Response
    {
        return match((int) $user->role) {
            User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
            User::ROLE_CHEF => redirect()->route('chef.dashboard'),
            User::ROLE_WAITER => redirect()->route('waiter.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
