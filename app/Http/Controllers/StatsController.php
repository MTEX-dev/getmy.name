<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatsController extends Controller
{
    /**
     * Display the stats page (Private for User or Public for Platform)
     */
    public function apiRequests(Request $request, $from = null, $to = null)
    {
        $isPublic = $request->routeIs('stats.public');
        $user = Auth::user();
        
        $query = ApiRequest::query();
        if (!$isPublic) {
            $query->where('user_id', $user->id);
        }

        $stats = [
            'total' => (clone $query)->count(),
            'today' => (clone $query)->whereDate('created_at', Carbon::today())->count(),
            'isPublic' => $isPublic
        ];

        return view('stats.api-requests', compact('stats'));
    }

    /**
     * Return JSON data for the chart.
     */
    public function getApiRequestData(Request $request)
    {
        $isPublic = $request->get('global') === 'true';
        $user = Auth::user();
        
        // Ensure non-auth users can't see private stats
        if (!$isPublic && !$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $range = $request->get('range', '30d');
        $now = Carbon::now();
        $unit = 'day';
        $format = 'Y-m-d';
        $step = 'addDay';

        // Range Logic
        if ($range === 'custom') {
            $startDate = $request->get('from') ? Carbon::parse($request->get('from'))->startOfDay() : $now->copy()->subDays(29)->startOfDay();
            $endDate = $request->get('to') ? Carbon::parse($request->get('to'))->endOfDay() : $now;
        } else {
            $endDate = $now;
            switch ($range) {
                case '1h': $startDate = $now->copy()->subHour(); $unit = 'minute'; $format = 'Y-m-d H:i:00'; $step = 'addMinute'; break;
                case '24h': $startDate = $now->copy()->subDay(); $unit = 'hour'; $format = 'Y-m-d H:00:00'; $step = 'addHour'; break;
                case '7d': $startDate = $now->copy()->subDays(6)->startOfDay(); break;
                case '90d': $startDate = $now->copy()->subDays(89)->startOfDay(); break;
                case 'lifetime': 
                    $first = ApiRequest::oldest()->first();
                    $startDate = $first ? $first->created_at->startOfDay() : $now->copy()->subDays(30)->startOfDay(); 
                    break;
                default: $startDate = $now->copy()->subDays(29)->startOfDay(); break;
            }
        }

        $query = ApiRequest::whereBetween('created_at', [$startDate, $endDate]);
        
        if (!$isPublic) {
            $query->where('user_id', $user->id);
        }

        // Aggregate Data
        $dbData = match($unit) {
            'minute' => $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:00') as timeframe, COUNT(*) as count"),
            'hour' => $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as timeframe, COUNT(*) as count"),
            default => $query->selectRaw("DATE(created_at) as timeframe, COUNT(*) as count"),
        }
        ->groupBy('timeframe')
        ->pluck('count', 'timeframe');

        $labels = [];
        $counts = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $key = $current->format($unit === 'day' ? 'Y-m-d' : $format);
            $labels[] = $key;
            $counts[] = $dbData->get($key, 0);
            $current->$step();
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'unit' => $unit,
            'stats' => [
                'total' => (clone $query)->count(),
                'today' => (clone $query)->whereDate('created_at', Carbon::today())->count(),
            ]
        ]);
    }
}