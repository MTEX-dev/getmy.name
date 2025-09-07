<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AboutMeController extends Controller
{
    public function index($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return response()->json(['about_me' => $user->about_me]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'about_me' => 'nullable|string',
        ]);

        $user->update($validatedData);

        return response()->json(['about_me' => $user->about_me]);
    }
}