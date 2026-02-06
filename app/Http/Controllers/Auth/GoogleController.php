<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Throwable $exception) {
            Log::warning('Google OAuth failed', [
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Google sign-in failed. Please try again.',
                ]);
        }

        $user = $this->resolveUser($googleUser);

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }

    private function resolveUser(SocialiteUser $googleUser): User
    {
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user === null && $googleUser->getEmail() !== null) {
            $user = User::where('email', $googleUser->getEmail())->first();
        }

        if ($user === null) {
            return User::create([
                'name' => $googleUser->getName() ?? 'Google User',
                'email' => $googleUser->getEmail() ?? Str::uuid().'@example.com',
                'password' => Hash::make(Str::random(32)),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
                'role' => 'customer',
            ]);
        }

        if ($user->google_id === null) {
            $user->google_id = $googleUser->getId();

            if ($user->email_verified_at === null) {
                $user->email_verified_at = now();
            }

            $user->save();
        }

        return $user;
    }
}
