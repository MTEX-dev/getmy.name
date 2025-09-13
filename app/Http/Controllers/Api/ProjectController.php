<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index($username)
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->firstOrFail();
        return response()->json($user->projects->makeHidden(['user_id']));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $project = $user->projects()->create($validatedData);

        return response()->json($project, 201);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json(null, 204);
    }

    public function addFeature(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validatedData = $request->validate([
            'feature' => 'required|string|max:255',
        ]);

        $project->features()->create($validatedData);

        return response()->json($project->load('features'));
    }

    public function updateFeature(Request $request, Project $project, $featureId)
    {
        $this->authorize('update', $project);

        $validatedData = $request->validate([
            'feature' => 'required|string|max:255',
        ]);

        $feature = $project->features()->findOrFail($featureId);
        $feature->update($validatedData);

        return response()->json($project->load('features'));
    }

    public function removeFeature(Project $project, $featureId)
    {
        $this->authorize('update', $project);

        $feature = $project->features()->findOrFail($featureId);
        $feature->delete();

        return response()->json($project->load('features'));
    }
}