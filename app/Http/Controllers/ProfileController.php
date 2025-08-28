<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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
        $validatedData = $request->validated();

        if (isset($validatedData['location_manual'])) {
            $validatedData['location'] = $validatedData['location_manual'];
            unset($validatedData['location_manual']);
        } elseif (isset($validatedData['location']) && $validatedData['location'] === 'Type Manually') {
            $validatedData['location'] = null;
        }

        $request->user()->fill($validatedData);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:1024'],
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');

        if ($oldAvatar = $request->user()->avatar_path) {
            Storage::disk('public')->delete($oldAvatar);
        }

        $request->user()->update(['avatar_path' => $path]);

        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }

    public function destroyAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->update(['avatar_path' => null]);
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-removed');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function preview(): View
    {
        $user = Auth::user();
        $response = Http::get(route('get.data', ['user' => $user]));
        $data = $response->json();

        return view('profiles.get', compact('data'));
    }

    public function getData(User $user): array
    {
        $user->load(['skills', 'projects', 'socials', 'education', 'experiences']);

        return [
            'name' => $user->name,
            'username' => $user->username,
            'title' => $user->title,
            'bio' => $user->bio,
            'location' => $user->location,
            'avatar_url' => $user->avatar(),
            'email' => $user->email,
            'skills' => $user->skills->pluck('name')->toArray(),
            'projects' => $user->projects->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,
                    'url' => $project->url,
                    'image_path' => $project->image_path ? Storage::url($project->image_path) : null,
                ];
            })->toArray(),
            'socials' => $user->socials
                ? $user->socials->only(['github', 'linkedin', 'twitter', 'personal_website'])
                : [],
        ];
    }
}