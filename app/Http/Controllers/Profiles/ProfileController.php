<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileSkill;
use App\Models\ProfileProject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $userProfile = $request->user()->profile;

        if (!$userProfile) {
            return redirect()->route('profiles.create');
        }

        $userProfile->load(['skills', 'projects', 'socials']);

        return view('profiles.show', [
            'profile' => $userProfile,
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if (auth()->user()->profile) {
            return redirect()->route('profiles.index')->with('warning', 'You already have a portfolio profile.');
        }

        return view('profiles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('profiles', 'username')],
            'title' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        auth()->user()->profile()->create([
            'username' => $request->username,
            'title' => $request->title,
            'email' => $request->email,
        ]);

        return redirect()->route('profiles.index')->with('status', 'Profile created successfully.');
    }

    public function show(Request $request): View
    {
        $profile = $request->user()->profile()->with(['skills', 'projects', 'socials'])->firstOrFail();

        return view('profiles.show', [
            'profile' => $profile,
        ]);
    }

    public function edit(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();

        return view('profiles.edit', [
            'profile' => $profile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validate([
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('profiles', 'username')->ignore($profile->id)],
            'title' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $profile->update([
            'username' => $request->username,
            'title' => $request->title,
            'email' => $request->email,
        ]);

        return redirect()->route('profiles.index')->with('status', 'Profile information updated successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validateWithBag('profileDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $profile->delete();

        return redirect()->route('dashboard')->with('status', 'Profile deleted successfully.');
    }

    public function addSkill(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validate(['name' => 'required|string|max:255']);

        $profile->skills()->create(['name' => $request->name]);

        return back()->with('status', 'Skill added.');
    }

    public function destroySkill(ProfileSkill $skill): RedirectResponse
    {
        if ($skill->profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $skill->delete();

        return back()->with('status', 'Skill removed.');
    }

    public function createProfileProject(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();

        return view('profiles.projects.create', compact('profile'));
    }

    public function storeProfileProject(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('project_images', 'public')
            : null;

        $profile->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('profiles.index')->with('status', 'Project added successfully.');
    }

    public function editProfileProject(ProfileProject $project): View|RedirectResponse
    {
        if ($project->profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('profiles.projects.edit', compact('project'));
    }

    public function updateProfileProject(Request $request, ProfileProject $project): RedirectResponse
    {
        if ($project->profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $project->image_path = $request->file('image')->store('project_images', 'public');
        }

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        return redirect()->route('profiles.index')->with('status', 'Project updated successfully.');
    }

    public function destroyProfileProject(ProfileProject $project): RedirectResponse
    {
        if ($project->profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }

        $project->delete();

        return back()->with('status', 'Project removed.');
    }

    public function editProfileSocials(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();
        $socials = $profile->socials;

        return view('profiles.socials.edit', compact('profile', 'socials'));
    }

    public function updateProfileSocials(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validate([
            'github' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'personal_website' => 'nullable|url|max:255',
        ]);

        $profileSocialData = $request->only(['github', 'linkedin', 'twitter', 'personal_website']);

        $profile->socials()->updateOrCreate(
            ['profile_id' => $profile->id],
            $profileSocialData
        );

        return redirect()->route('profiles.index')->with('status', 'Social links updated.');
    }
}
