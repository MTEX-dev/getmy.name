<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Feature;
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
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $project->image = $request->file('image')->store('projects', 'public');
        }

        $project->fill($validated);
        $project->save();

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

    public function updateTechnology(Request $request, Project $project, Technology $technology): RedirectResponse
    {
        if (Auth::id() !== $project->user_id || $project->id !== $technology->project_id) {
            abort(403);
        }

        $validated = $request->validate([
            'technologie' => ['required', 'string', 'max:255'],
        ]);

        $technology->update($validated);

        return Redirect::route('profile.projects.edit', $project)->with('status', 'technology-updated');
    }

    public function removeTechnology(
        Project $project,
        Technology $technology,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id || $project->id !== $technology->project_id) {
            abort(403);
        }

        $technology->delete();

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

    public function updateFeature(Request $request, Project $project, Feature $feature): RedirectResponse
    {
        if (Auth::id() !== $project->user_id || $project->id !== $feature->project_id) {
            abort(403);
        }

        $validated = $request->validate([
            'feature' => ['required', 'string', 'max:255'],
        ]);

        $feature->update($validated);

        return Redirect::route('profile.projects.edit', $project)->with('status', 'feature-updated');
    }

    public function removeFeature(
        Project $project,
        Feature $feature,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id || $project->id !== $feature->project_id) {
            abort(403);
        }

        $feature->delete();

        return Redirect::route('profile.projects.edit', $project)->with('status', 'feature-removed');
    }
}