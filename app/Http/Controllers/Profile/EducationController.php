<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EducationController extends Controller
{
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

        return Redirect::route('profile.education')->with('status', 'education-added');
    }

    public function destroy(Education $education): RedirectResponse
    {
        if (Auth::id() === $education->user_id) {
            $education->delete();

            return Redirect::route('profile.education')->with('status', 'education-deleted');
        } else {
            abort(403);
        }
    }
}