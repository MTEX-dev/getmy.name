<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function edit(Experience $experience): View
    {
        if (Auth::id() !== $experience->user_id) {
            abort(403);
        }

        return view('profile.experiences-edit', compact('experience'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string', 'max:2048'],
        ]);

        $request->user()->experiences()->create($validated);

        return Redirect::route('profile.edit')->with('status', 'experience-added');
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        if (Auth::id() !== $experience->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string', 'max:2048'],
        ]);

        $experience->update($validated);

        return Redirect::route('profile.edit')->with('status', 'experience-updated');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        if (Auth::id() === $experience->user_id) {
            $experience->delete();
            return Redirect::back()->with('status', 'experience-deleted');
        }
        abort(403);
    }
}