<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class AvatarController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:1024'],
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');

        if ($oldAvatar = $request->user()->avatar_path) {
            Storage::disk('public')->delete($oldAvatar);
        }

        $request->user()->update(['avatar_path' => $path]);

        return Redirect::route('profile.avatar')->with('status', 'avatar-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->update(['avatar_path' => null]);
        }

        return Redirect::route('profile.avatar')->with('status', 'avatar-removed');
    }
}