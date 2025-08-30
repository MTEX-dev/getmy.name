<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SkillController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
        ]);

        $request->user()->skills()->create($validated);

        return Redirect::route('profile.edit')->with('status', 'skill-added');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        if(Auth::id() === $skill->user_id) {
            $skill->delete();

            return Redirect::route('profile.edit')->with('status', 'skill-deleted');
        } else {
            abort(403);
        }
    }
}