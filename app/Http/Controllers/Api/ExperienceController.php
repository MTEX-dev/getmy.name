<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function index($username)
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->firstOrFail();
        return response()->json($user->experiences->makeHidden(['user_id']));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $experience = $user->experiences()->create($validatedData);

        return response()->json($experience, 201);
    }

    public function destroy(Experience $experience)
    {
        $this->authorize('delete', $experience);

        $experience->delete();

        return response()->json(null, 204);
    }
}