<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SocialsController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'github' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'personal_website' => ['nullable', 'url', 'max:2048'],
            'codepen' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:2048'],
        ]);

        $user = $request->user();

        $socials = Social::firstOrNew(['user_id' => $user->id]);
        $socials->fill($validated);
        $socials->save();

        return Redirect::route('profile.socials')->with('status', 'socials-updated');
    }
}