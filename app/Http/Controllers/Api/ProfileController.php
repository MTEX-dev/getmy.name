<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($username)])->firstOrFail();

        return response()->json($user->profileData());
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $user->update($validatedData);

        return response()->json($user->profileData());
    }
}