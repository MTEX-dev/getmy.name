<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialsController extends Controller
{
    public function index($username)
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->firstOrFail();
        return response()->json($user->socials);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'github' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'bluesky' => ['nullable', 'string', 'max:255'],
            'personal_website' => ['nullable', 'url', 'max:2048'],
            'codepen' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:2048'],
            'stackoverflow' => ['nullable', 'string', 'max:255'],
            'dev_to' => ['nullable', 'string', 'max:255'],
            'hashnode' => ['nullable', 'string', 'max:255'],
            'npm' => ['nullable', 'string', 'max:255'],
            'product_hunt' => ['nullable', 'string', 'max:255'],
            'polywork' => ['nullable', 'string', 'max:255'],
            'gitlab' => ['nullable', 'string', 'max:255'],
            'dribbble' => ['nullable', 'string', 'max:255'],
            'figma' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validatedData as $platform => $username) {
            $user->socials()->updateOrCreate(
                ['platform' => $platform],
                ['username' => $username]
            );
        }

        return response()->json($user->socials);
    }
}