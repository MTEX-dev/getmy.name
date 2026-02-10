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

        return Redirect::route('profile.skills')->with('success', __('profile.skill_added_successfully'));
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        if (Auth::id() !== $skill->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
        ]);

        $skill->update($validated);

        return Redirect::route('profile.skills')->with('success', __('profile.skill_updated_successfully'));
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        if (Auth::id() === $skill->user_id) {
            $skill->delete();
            return Redirect::route('profile.skills')->with('info', __('profile.skill_removed_successfully'));
        }
        
        abort(403);
    }
}