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
    public function apiRequests(Request $request)
    {
        // Check if we are on the public route
        $isPublic = $request->routeIs('stats.public');
        $user = Auth::user();

        // Security/Safety check: If private route but no user, redirect or abort
        if (!$isPublic && !$user) {
            abort(403, 'Unauthorized');
        }

        $query = ApiRequest::query();
        
        if (!$isPublic && $user) {
            $query->where('user_id', $user->id);
        }

        // We calculate initial stats here for the Blade view to render immediately (Server Side)
        // Note: Charts will fetch their own data via AJAX later.
        $totalCount = (clone $query)->count();
        $todayCount = (clone $query)->whereDate('created_at', Carbon::today())->count();

        $stats = [
            'total' => $totalCount,
            'today' => $todayCount,
            'isPublic' => $isPublic
        ];

        return view('stats.api-requests', compact('stats'));
    }

    /**
     * Return JSON data for the chart.
     */
    public function getApiRequestData(Request $request)
    {
        // Determine mode based on request input or route logic
        $isPublic = $request->boolean('global'); 
        $user = Auth::user();

        // Security check for JSON data
        if (!$isPublic && !$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $range = $request->get('range', '30d');
        $now = Carbon::now();
        $unit = 'day';
        $format = 'Y-m-d';
        $step = 'addDay';

        // 1. Determine Date Range
        if ($range === 'custom') {
            $startDate = $request->get('from') ? Carbon::parse($request->get('from'))->startOfDay() : $now->copy()->subDays(29)->startOfDay();
            $endDate = $request->get('to') ? Carbon::parse($request->get('to'))->endOfDay() : $now;
        } else {
            $endDate = $now;
            switch ($range) {
                case '1h': 
                    $startDate = $now->copy()->subHour(); 
                    $unit = 'minute'; 
                    $format = 'Y-m-d H:i:00'; 
                    $step = 'addMinute'; 
                    break;
                case '24h': 
                    $startDate = $now->copy()->subDay(); 
                    $unit = 'hour'; 
                    $format = 'Y-m-d H:00:00'; 
                    $step = 'addHour'; 
                    break;
                case '7d': 
                    $startDate = $now->copy()->subDays(6)->startOfDay(); 
                    break;
                case '90d': 
                    $startDate = $now->copy()->subDays(89)->startOfDay(); 
                    break;
                case 'lifetime': 
                    // Optimization: Check if public or private to get the oldest record
                    $q = ApiRequest::query();
                    if (!$isPublic && $user) { $q->where('user_id', $user->id); }
                    $first = $q->oldest()->first();
                    $startDate = $first ? $first->created_at->startOfDay() : $now->copy()->subDays(30)->startOfDay(); 
                    break;
                case '30d':
                default: 
                    $startDate = $now->copy()->subDays(29)->startOfDay(); 
                    break;
            }
        }

        // 2. Build Query
        $query = ApiRequest::whereBetween('created_at', [$startDate, $endDate]);
        
        if (!$isPublic && $user) {
            $query->where('user_id', $user->id);
        }

        // 3. Aggregate Data
        // We use different Date Formats based on the unit granularity
        if ($unit === 'minute') {
            $dbData = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:00') as timeframe, COUNT(*) as count")
                ->groupBy('timeframe')->pluck('count', 'timeframe');
        } elseif ($unit === 'hour') {
            $dbData = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as timeframe, COUNT(*) as count")
                ->groupBy('timeframe')->pluck('count', 'timeframe');
        } else {
            $dbData = $query->selectRaw("DATE(created_at) as timeframe, COUNT(*) as count")
                ->groupBy('timeframe')->pluck('count', 'timeframe');
        }

        // 4. Fill Gaps
        $labels = [];
        $counts = [];
        $current = $startDate->copy();
        
        // Safety: Limit loop to avoid infinite execution on bad dates
        $loops = 0;
        while ($current <= $endDate && $loops < 2000) {
            $key = $current->format($unit === 'day' ? 'Y-m-d' : $format);
            $labels[] = $key;
            $counts[] = $dbData->get($key, 0);
            $current->$step();
            $loops++;
        }

        // 5. Return Stats for the cards (re-calculated for the specific range/context if needed, 
        // but here we usually return total/today regardless of range for the summary cards)
        // Re-using the base query logic for total/today summary
        $summaryQuery = ApiRequest::query();
        if (!$isPublic && $user) { $summaryQuery->where('user_id', $user->id); }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'unit' => $unit,
            'stats' => [
                'total' => (clone $summaryQuery)->count(),
                'today' => (clone $summaryQuery)->whereDate('created_at', Carbon::today())->count(),
            ]
        ]);
    }
}