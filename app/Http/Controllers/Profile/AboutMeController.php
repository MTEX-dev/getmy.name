<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;

class AboutMeController extends Controller
{
    /**
     * Display the user's about me form.
     */
    public function edit(): \Illuminate\View\View
    {
        return view('profile.edit');
    }

    /**
     * Update the user's about me information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'about_me' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', __('auth.not_authenticated'));
        }

        $user->about_me = $validatedData['about_me'];

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'about-me-updated');
    }
}