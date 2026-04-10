<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    private function driver(string $provider): string
    {
        return $provider === 'twitter' ? 'twitter-oauth-2' : $provider;
    }

    public function redirect(string $provider)
    {
        return Socialite::driver($this->driver($provider))->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($this->driver($provider))->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Social login failed. Please try again.');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'              => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'email'             => $socialUser->getEmail(),
                'password'          => bcrypt(\Illuminate\Support\Str::random(32)),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('Client');

            Client::create([
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}
