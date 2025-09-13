<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function edit(Project $project)
    {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        return view('profile.projects.edit', [
            'user' => Auth::user(),
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2048'],
            'url' => ['nullable', 'url', 'max:2048'],
            'github_url' => ['nullable', 'url', 'max:2048'],
            'live_demo_url' => ['nullable', 'url', 'max:2048'],
            'role' => ['nullable', 'string', 'max:255'],
            'challenges' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['string', 'max:255'],
            'new_technologies' => ['nullable', 'array'],
            'new_technologies.*' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
            'new_features' => ['nullable', 'array'],
            'new_features.*' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $project->image = $request->file('image')->store('projects', 'public');
        }

        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->url = $validated['url'];
        $project->github_url = $validated['github_url'];
        $project->live_demo_url = $validated['live_demo_url'];
        $project->role = $validated['role'];
        $project->challenges = $validated['challenges'];
        $project->save();

        if (isset($validated['technologies'])) {
            foreach ($validated['technologies'] as $uuid => $technologie) {
                $project->technologies()->where('uuid', $uuid)->update(['technologie' => $technologie]);
            }
        }

        if (isset($validated['new_technologies'])) {
            foreach ($validated['new_technologies'] as $newTechnologie) {
                if ($newTechnologie) {
                    $project->technologies()->create(['technologie' => $newTechnologie]);
                }
            }
        }

        if (isset($validated['features'])) {
            foreach ($validated['features'] as $uuid => $feature) {
                $project->features()->where('uuid', $uuid)->update(['feature' => $feature]);
            }
        }

        if (isset($validated['new_features'])) {
            foreach ($validated['new_features'] as $newFeature) {
                if ($newFeature) {
                    $project->features()->create(['feature' => $newFeature]);
                }
            }
        }

        return Redirect::route('profile.projects.edit', $project)->with('status', 'project-updated');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2048'],
            'url' => ['nullable', 'url', 'max:2048'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project = $request->user()->projects()->create($validated);

        return Redirect::route('profile.projects.edit', $project)->with('status', 'project-added');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if (Auth::id() === $project->user_id) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $project->delete();

            return Redirect::route('profile.projects')->with('status', 'project-deleted');
        } else {
            abort(403);
        }
    }

    public function removeImage(Project $project): RedirectResponse
    {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
            $project->image = null;
            $project->save();
        }

        return Redirect::route('profile.projects.edit', $project)->with('status', 'image-removed');
    }

    public function addTechnology(
        Request $request,
        Project $project,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'technologie' => ['required', 'string', 'max:255'],
        ]);

        $project->technologies()->create($validated);

        return Redirect::route('profile.projects.edit', $project)->with('status', 'technology-added');
    }

    public function removeTechnology(
        Project $project,
        string $technology,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $project->technologies()->where('uuid', $technology)->delete();

        return Redirect::route('profile.projects.edit', $project)->with('status', 'technology-removed');
    }

    public function addFeature(Request $request, Project $project): RedirectResponse
    {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'feature' => ['required', 'string', 'max:255'],
        ]);

        $project->features()->create($validated);

        return Redirect::route('profile.projects.edit', $project)->with('status', 'feature-added');
    }

    public function removeFeature(
        Project $project,
        string $feature,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $project->features()->where('uuid', $feature)->delete();

        return Redirect::route('profile.projects.edit', $project)->with('status', 'feature-removed');
    }
}