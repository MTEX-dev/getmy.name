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
use App\Models\ApiRequest;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load(['skills', 'projects', 'socials', 'education', 'experiences']);
        return view('profile.edit', compact('user'));
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
        $request = Request::create('/preview', 'GET');
        $data = $this->getData($request, $user);

        return view('profiles.get', compact('data'));
    }

    public function getData(Request $request, User $user): array
    {
        $user->load(['skills', 'projects', 'socials', 'education', 'experiences']);

        ApiRequest::create([
            'user_id' => $user->id,
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'requested_at' => now(),
        ]);

        return [
            'name' => $user->name,
            'username' => $user->username,
            'title' => $user->title,
            'bio' => $user->bio,
            'location' => $user->location,
            'avatar_url' => $user->getAvatarUrl(),
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
            'api_request_count' => $user->getApiRequestCount(),
        ];
    }

    public function editSkills(Request $request): View
    {
        $user = $request->user();
        $user->load(['skills']);
        return view('profile.skills', compact('user'));
    }

    public function editProjects(Request $request): View
    {
        $user = $request->user();
        $user->load(['projects']);
        return view('profile.projects', compact('user'));
    }

    public function editExperiences(Request $request): View
    {
        $user = $request->user();
        $user->load(['experiences']);
        return view('profile.experiences', compact('user'));
    }

    public function editSocials(Request $request): View
    {
        $user = $request->user();
        $user->load(['socials']);
        return view('profile.socials', compact('user'));
    }
}
