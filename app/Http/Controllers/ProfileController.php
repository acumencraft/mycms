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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Phone განახლება client record-ში
        if ($request->filled('phone')) {
            $client = $request->user()->client;
            if ($client) {
                $client->update([
                    'phone' => $request->phone,
                    'name'  => $request->name,
                    'email' => $request->email,
                ]);
            } else {
                Client::create([
                    'user_id' => $request->user()->id,
                    'name'    => $request->name,
                    'email'   => $request->email,
                    'phone'   => $request->phone,
                ]);
            }
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
