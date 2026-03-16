<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'                      => $googleUser->getName(),
                'google_id'                 => $googleUser->getId(),
                'avatar'                    => $googleUser->getAvatar(),
                'google_access_token'       => $googleUser->token,
                'google_refresh_token'      => $googleUser->refreshToken,
                'google_token_expires_at'   => now()->addSeconds($googleUser->expiresIn),
                'password'                  => bcrypt(str()->random(24)),
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}