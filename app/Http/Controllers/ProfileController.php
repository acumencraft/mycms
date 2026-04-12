<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // tags გავფილტროთ
        if (isset($data['tags'])) {
            $data['tags'] = array_values(array_filter(array_map('trim', $data['tags'])));
        }

        // User fields
        $request->user()->fill([
            'name'   => $data['name'],
            'email'  => $data['email'],
            'avatar' => $data['avatar'] ?? $request->user()->avatar,
            'bio'    => $data['bio'] ?? null,
            'tags'   => $data['tags'] ?? [],
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Client fields
        $clientData = [
            'name'            => $data['name'],
            'email'           => $data['email'],
            'phone'           => $data['phone'] ?? null,
            'company'         => $data['company'] ?? null,
            'country'         => $data['country'] ?? null,
            'website'         => $data['website'] ?? null,
            'industry'        => $data['industry'] ?? null,
            'social_linkedin' => $data['social_linkedin'] ?? null,
            'social_facebook' => $data['social_facebook'] ?? null,
            'timezone'        => $data['timezone'] ?? null,
            'birthday'        => $data['birthday'] ?? null,
        ];

        $client = $request->user()->client;
        if ($client) {
            $client->update($clientData);
        } else {
            Client::create(array_merge($clientData, ['user_id' => $request->user()->id]));
        }

        return Redirect::route('client-dashboard.profile')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
