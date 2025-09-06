<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tokens = $user->tokens;

        return view('profile.api-tokens', [
            'tokens' => $tokens,
            'availableAbilities' => config('sanctum.abilities'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'nullable|array',
            'abilities.*' => 'string',
        ]);

        $user = Auth::user();
        $abilities = $request->input('abilities', []);
        $token = $user->createToken($request->name, $abilities);

        return back()->with('status', 'api-token-created')->with('token', $token->plainTextToken);
    }

    public function destroy($tokenId)
    {
        $user = Auth::user();
        $user->tokens()->where('id', $tokenId)->delete();

        return back()->with('status', 'api-token-deleted');
    }
}