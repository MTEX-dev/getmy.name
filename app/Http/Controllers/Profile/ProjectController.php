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

        $request->user()->projects()->create($validated);

        return Redirect::route('profile.projects')->with('status', 'project-added');
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