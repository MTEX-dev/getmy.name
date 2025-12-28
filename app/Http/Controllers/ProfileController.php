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
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load(['skills', 'projects', 'socials', 'education', 'experiences']);
        return view('profile.edit', compact('user'));
    }

    public function password(Request $request): View
    {
        $user = $request->user();
        return view('profile.password', compact('user'));
    }

    public function avatar(Request $request): View
    {
        $user = $request->user();
        return view('profile.avatar', compact('user'));
    }

    public function design(Request $request): View
    {
        $user = $request->user();
        $templates = config('getmyname.design_templates');
        
        return view('profile.design', compact('user', 'templates'));
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

    public function updateTemplate(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'template' => [
                'required', 
                'string',
                Rule::in(config('getmyname.design_templates'))
            ],
        ]);

        $request->user()->update($validatedData);

        return Redirect::route('profile.design')->with('status', 'template-updated');
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

    public function preview(Request $request): View
    {
        $username = Auth::user()->username;
        $user = User::where('username', $username)->firstOrFail();
        $data = $user->profileData();

        return view('profile.preview', compact('data'));
    }

    public function getData(Request $request, string $username): array
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->firstOrFail();

        ApiRequest::create([
            'user_id' => $user->id,
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'requested_at' => now(),
        ]);

        return $user->profileData();
    }

    public function getProfile(Request $request, string $username): View
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->firstOrFail();
        $data = $this->getData($request, $username);

        $template = $user->template ?? 'default';
        $viewName = 'profile.get.' . $template;

        if (!view()->exists($viewName)) {
            $viewName = 'profile.get.default';
        }

        return view($viewName, compact('data'));
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

    public function editEducation(Request $request): View
    {
        $user = $request->user();
        $user->load(['education']);
        return view('profile.education', compact('user'));
    }

    public function activity(Request $request): View
    {
        $user = $request->user();
        $activity = \Spatie\Activitylog\Models\Activity::where('causer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('profile.activity', compact('activity'));
    }
}