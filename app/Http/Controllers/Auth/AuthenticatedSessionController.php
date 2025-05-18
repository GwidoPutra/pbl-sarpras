<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $user = auth()->user();

            // Check user role and redirect accordingly
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('mahasiswa')) {
                return redirect()->route('users.dashboard');
            }

            // Fallback if no appropriate role exists
            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Your account does not have the appropriate role.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/login')->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'An error occurred during login. Please try again.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'You have been successfully logged out!');
    }
}