<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileSkill;
use App\Models\ProfileProject; // Corrected import
use App\Models\ProfileSocial; // Corrected import
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
            return redirect()->route('profiles.create');
        }

        $userProfile->load(['skills', 'ProfileProjects', 'ProfileSocials']); // Corrected relations

        return view('profiles.show', [
            'profile' => $userProfile,
        ]);
    }

    /**
     * Show the form for creating a new portfolio profile.
     */
    public function create(): View|RedirectResponse
    {
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
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $profile = auth()->user()->profile()->create([
            'username' => $request->username,
            'title' => $request->title,
            'email' => $request->email,
        ]);

        return redirect()->route('profiles.show')->with('status', 'Profile created successfully.');
    }

    /**
     * Display the specified resource (Public API Endpoint - for future use).
     */
    public function show(Request $request): View
    {
        $profile = $request->user()->profile()->with(['skills', 'ProfileProjects', 'ProfileSocials'])->firstOrFail(); // Corrected relations

        return view('profiles.show', [
            'profile' => $profile,
        ]);
    }

    /**
     * Show the form for editing the specified portfolio profile's core information.
     */
    public function edit(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();
        return view('profiles.edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the specified portfolio profile's core information in storage.
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

        return redirect()->route('profiles.show')->with('status', 'Profile information updated successfully.');
    }

    /**
     * Remove the specified portfolio profile from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrFail();

        $request->validateWithBag('profileDeletion', [
            'password' => ['required', 'current_password'],
        ]);

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
        if ($skill->profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $skill->delete();

        return back()->with('status', 'Skill removed.');
    }

    // --- ProfileProject Management ---

    public function createProfileProject(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();
        return view('profiles.profile_projects.create', compact('profile')); // Corrected view path
    }

    public function storeProfileProject(Request $request): RedirectResponse
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
            $imagePath = $request->file('image')->store('profile_project_images', 'public'); // Corrected folder name
        }

        $profile->ProfileProjects()->create([ 
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('profiles.show')->with('status', 'Project added successfully.');
    }

    public function editProfileProject(ProfileProject $profileProject): View|RedirectResponse 
    {
        if ($profileProject->profile->user_id !== auth()->id()) { 
            abort(403, 'Unauthorized action.');
        }
        return view('profiles.profile_projects.edit', compact('profileProject')); 
    }

    public function updateProfileProject(Request $request, ProfileProject $profileProject): RedirectResponse 
    {
        if ($profileProject->profile->user_id !== auth()->id()) { 
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
            if ($profileProject->image_path) {
                Storage::disk('public')->delete($profileProject->image_path);
            }
            $imagePath = $request->file('image')->store('profile_project_images', 'public'); // Corrected folder name
            $profileProject->image_path = $imagePath;
        }

        $profileProject->update([ 
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            // image_path is updated above if present
        ]);

        return redirect()->route('profiles.show')->with('status', 'Project updated successfully.');
    }

    public function destroyProfileProject(ProfileProject $profileProject): RedirectResponse 
    {
        if ($profileProject->profile->user_id !== auth()->id()) { 
            abort(403, 'Unauthorized action.');
        }

        if ($profileProject->image_path) {
            Storage::disk('public')->delete($profileProject->image_path);
        }

        $profileProject->delete(); 

        return back()->with('status', 'Project removed.');
    }

    // --- ProfileSocial Management ---
    public function editProfileSocials(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrFail();
        $profileSocials = $profile->ProfileSocials; 
        return view('profiles.profile_socials.edit', compact('profile', 'profileSocials')); 
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

        $profile->ProfileSocials()->updateOrCreate( 
            ['profile_id' => $profile->id],
            $profileSocialData 
        );

        return redirect()->route('profiles.show')->with('status', 'Social links updated.');
    }
}