<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            User::FIELD_USERNAME => 'required|string|max:255',
            User::FIELD_EMAIL => 'required|string|lowercase|email|max:255|unique:' . User::class,
            User::FIELD_PASSWORD => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            User::FIELD_USERNAME => $request->username,
            User::FIELD_EMAIL => $request->email,
            User::FIELD_PASSWORD => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('creator.dashboard', absolute: false));
    }
}