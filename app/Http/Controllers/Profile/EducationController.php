<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EducationController extends Controller
{
    public function edit(Education $education): View
    {
        if (Auth::id() !== $education->user_id) {
            abort(403);
        }

        return view('profile.education-edit', compact('education'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string', 'max:2048'],
        ]);

        $request->user()->education()->create($validated);

        return Redirect::route('profile.edit')->with('status', 'education-added');
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        if (Auth::id() !== $education->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string', 'max:2048'],
        ]);

        $education->update($validated);

        return Redirect::route('profile.edit')->with('status', 'education-updated');
    }

    public function destroy(Education $education): RedirectResponse
    {
        if (Auth::id() === $education->user_id) {
            $education->delete();
            return Redirect::back()->with('status', 'education-deleted');
        }
        abort(403);
    }
}