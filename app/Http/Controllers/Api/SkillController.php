<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function index($username)
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->firstOrFail();
        return response()->json($user->skills->makeHidden(['user_id']));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
        ]);

        $skill = $user->skills()->create($validatedData);

        return response()->json($skill, 201);
    }

    public function destroy(Skill $skill)
    {
        $this->authorize('delete', $skill);

        $skill->delete();

        return response()->json(null, 204);
    }
}