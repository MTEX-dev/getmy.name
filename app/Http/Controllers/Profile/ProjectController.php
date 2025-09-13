<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($validated);

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

    public function updateTechnology(
        Request $request,
        Project $project,
        $technologyId,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'technologie' => ['required', 'string', 'max:255'],
        ]);

        $technology = $project->technologies()->findOrFail($technologyId);
        $technology->update($validated);

        return Redirect::route('profile.projects.edit', $project)->with('status', 'technology-updated');
    }

    public function removeTechnology(
        Project $project,
        $technologyId,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $technology = $project->technologies()->findOrFail($technologyId);
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

    public function updateFeature(
        Request $request,
        Project $project,
        $featureId,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'feature' => ['required', 'string', 'max:255'],
        ]);

        $feature = $project->features()->findOrFail($featureId);
        $feature->update($validated);

        return Redirect::route('profile.projects.edit', $project)->with('status', 'feature-updated');
    }

    public function removeFeature(
        Project $project,
        $featureId,
    ): RedirectResponse {
        if (Auth::id() !== $project->user_id) {
            abort(403);
        }

        $feature = $project->features()->findOrFail($featureId);
        $feature->delete();

        return Redirect::route('profile.projects.edit', $project)->with('status', 'feature-removed');
    }
}