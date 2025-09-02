<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApiRequestController extends Controller
{
    public function index()
    {
        return view('profile.api-requests');
    }

    public function getApiRequestData(Request $request)
    {
        $user = Auth::user();

        $data = ApiRequest::where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $labels = $data->pluck('date');
        $counts = $data->pluck('count');

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
        ]);
    }
}