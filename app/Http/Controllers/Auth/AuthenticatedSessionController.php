<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.login', [
            'asMitra' => $request->query('as') === 'mitra',
        ]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        if ($user->isVendor()) {
            if ($user->vendorProfile && $user->vendorProfile->status === 'approved') {
                return redirect()->intended(route('vendor.dashboard', absolute: false));
            }

            return redirect()->intended(route('vendor.register', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
