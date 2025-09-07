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
            'github_username' => 'nullable|string|max:255',
            'linkedin_username' => 'nullable|string|max:255',
            'twitter_username' => 'nullable|string|max:255',
            'personal_website_url' => 'nullable|url',
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