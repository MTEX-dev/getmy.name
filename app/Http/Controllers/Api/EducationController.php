<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return response()->json($user->education);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $education = $user->education()->create($validatedData);

        return response()->json($education, 201);
    }

    public function destroy(Education $education)
    {
        $this->authorize('delete', $education);

        $education->delete();

        return response()->json(null, 204);
    }
}