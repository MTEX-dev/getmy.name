<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ApiRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total' => ApiRequest::where('user_id', $user->id)->count(),
            'month' => ApiRequest::where('user_id', $user->id)
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->count(),
            'today' => ApiRequest::where('user_id', $user->id)
                ->whereDate('created_at', Carbon::today())
                ->count(),
        ];

        return view('profile.api-requests', compact('stats'));
    }

    public function getApiRequestData(Request $request)
    {
        $user = Auth::user();
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(29); 

        $rawData = ApiRequest::where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('count', 'date');

        $period = CarbonPeriod::create($startDate, $endDate);
        $labels = [];
        $counts = [];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $labels[] = $formattedDate;
            $counts[] = $rawData->get($formattedDate, 0);
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
        ]);
    }
}