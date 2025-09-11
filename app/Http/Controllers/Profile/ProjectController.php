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
            'technologies' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($validated);

        $project->technologies()->delete();
        if ($request->technologies) {
            $technologies = array_map('trim', explode(',', $request->technologies));
            foreach ($technologies as $technology) {
                $project->technologies()->create(['technologie' => $technology]);
            }
        }

        $project->features()->delete();
        if ($request->features) {
            $features = array_map('trim', explode(',', $request->features));
            foreach ($features as $feature) {
                $project->features()->create(['feature' => $feature]);
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
}