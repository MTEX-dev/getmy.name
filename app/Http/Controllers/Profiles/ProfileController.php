<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileSkill;
use App\Models\Project;
use App\Models\ProfileSocial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's portfolio profile or prompt to create one.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $userProfile = $request->user()->profile;

        if (!$userProfile) {
            // If the user doesn't have a profile yet, redirect to create form
            return redirect()->route('profiles.create');
        }

        // Load relations for display
        $userProfile->load(['skills', 'projects', 'socials']);

        return view('profiles.show', [
            'profile' => $userProfile,
        ]);
    }

    /**
     * Show the form for creating a new portfolio profile.
     */
    public function create(): View|RedirectResponse
    {
        // A user should only have one portfolio profile for now
        if (auth()->user()->profile) {
            return redirect()->route('profiles.index')->with('warning', 'You already have a portfolio profile.');
        }

        return view('profiles.create');
    }

    /**
     * Store a newly created portfolio profile in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('profiles', 'username')],
            'title' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'], // This email is for the public profile, not user auth
        ]);

        $profile = auth()->user()->profile()->create([
            'username' => $request->username,
            'title' => $request->title,
            'email' => $request->email,
        ]);

        return redirect()->route('profiles.show')->with('status', 'Profile created successfully.');
    }

    /**
     * Display the specified resource (Public API Endpoint - for future use, assuming `show` returns JSON).
     * For now, this is internal and will display the authenticated user's profile.
     */
    public function show(Request $request): View
    {
        $profile = $request->user()->profile()->with(['skills', 'projects', 'socials'])->firstOrFail();

        return view('profiles.show', [
            'profile' => $profile,
        ]);
    }

    /**
     * Show the form for editing the specified portfolio profile.
     */
    public function edit(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();
        return view('profiles.edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the specified portfolio profile in storage.
     */
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

        return redirect()->route('profiles.show')->with('status', 'Profile updated successfully.');
    }

    /**
     * Remove the specified portfolio profile from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        // Optionally, prompt for password confirmation for a destructive action
        $request->validateWithBag('profileDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Delete related data (skills, projects, socials) handled by cascadeOnDelete
        $profile->delete();

        return redirect()->route('dashboard')->with('status', 'Profile deleted successfully.');
    }

    // --- Profile Skill Management ---

    public function addSkill(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();
        $request->validate(['name' => 'required|string|max:255']);

        $profile->skills()->create(['name' => $request->name]);

        return back()->with('status', 'Skill added.');
    }

    public function destroySkill(ProfileSkill $skill): RedirectResponse
    {
        // Ensure the skill belongs to the authenticated user's profile
        if ($skill->profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $skill->delete();

        return back()->with('status', 'Skill removed.');
    }

    // --- Project Management ---

    public function createProject(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();
        return view('profiles.projects.create', compact('profile'));
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('project_images', 'public');
        }

        $profile->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('profiles.show')->with('status', 'Project added successfully.');
    }

    public function editProject(Project $project): View|RedirectResponse
    {
        if ($project->profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('profiles.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project): RedirectResponse
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
            // Delete old image if exists
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $imagePath = $request->file('image')->store('project_images', 'public');
            $project->image_path = $imagePath;
        }

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        return redirect()->route('profiles.show')->with('status', 'Project updated successfully.');
    }

    public function destroyProject(Project $project): RedirectResponse
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

    // --- Socials Management ---
    public function editSocials(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();
        $socials = $profile->socials; // This might be null if not created yet
        return view('profiles.socials.edit', compact('profile', 'socials'));
    }

    public function updateSocials(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validate([
            'github' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'personal_website' => 'nullable|url|max:255',
        ]);

        $socialData = $request->only(['github', 'linkedin', 'twitter', 'personal_website']);

        $profile->socials()->updateOrCreate(
            ['profile_id' => $profile->id], // Find by profile_id
            $socialData // Data to update/create
        );

        return redirect()->route('profiles.show')->with('status', 'Social links updated.');
    }
}