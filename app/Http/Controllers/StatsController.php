<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatsController extends Controller
{
    /**
     * Display the stats page.
     */
    public function apiRequests(Request $request)
    {
        $user = Auth::user();
        
        // Basic stats for the summary cards
        $stats = [
            'total' => ApiRequest::where('user_id', $user->id)->count(),
            'today' => ApiRequest::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count(),
        ];

        return view('stats.api-requests', compact('stats'));
    }

    /**
     * Return JSON data for the chart.
     */
    public function getApiRequestData(Request $request)
    {
        $user = Auth::user();
        $range = $request->get('range', '30d');
        
        $now = Carbon::now();
        $unit = 'day';
        $format = 'Y-m-d';
        $step = 'addDay';

        // Custom range handling or Preset handling
        if ($range === 'custom') {
            $startDate = $request->get('from') ? Carbon::parse($request->get('from'))->startOfDay() : $now->copy()->subDays(29)->startOfDay();
            $endDate = $request->get('to') ? Carbon::parse($request->get('to'))->endOfDay() : $now;
            
            // Determine unit based on diff
            $diffInDays = $startDate->diffInDays($endDate);
            if ($diffInDays <= 2) {
                $unit = 'hour';
                $format = 'Y-m-d H:00:00';
                $step = 'addHour';
            }
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
                    $firstReq = ApiRequest::where('user_id', $user->id)->oldest()->first();
                    $startDate = $firstReq ? $firstReq->created_at->startOfDay() : $now->copy()->subDays(30)->startOfDay();
                    break;
                case '30d':
                default:
                    $startDate = $now->copy()->subDays(29)->startOfDay();
                    break;
            }
        }

        $query = ApiRequest::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Grouping logic based on unit
        if ($unit === 'minute') {
            $dbData = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:00') as timeframe, COUNT(*) as count")->groupBy('timeframe')->pluck('count', 'timeframe');
        } elseif ($unit === 'hour') {
            $dbData = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as timeframe, COUNT(*) as count")->groupBy('timeframe')->pluck('count', 'timeframe');
        } else {
            $dbData = $query->selectRaw("DATE(created_at) as timeframe, COUNT(*) as count")->groupBy('timeframe')->pluck('count', 'timeframe');
        }

        // Fill gaps with 0
        $labels = [];
        $counts = [];
        $current = $startDate->copy();

        // Safety break for loop
        $loops = 0;
        while ($current <= $endDate && $loops < 1000) {
            $key = $current->format($unit === 'day' ? 'Y-m-d' : $format);
            $labels[] = $key;
            $counts[] = $dbData->get($key, 0);
            $current->$step();
            $loops++;
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'unit' => $unit,
            'stats' => [
                'total' => ApiRequest::where('user_id', $user->id)->count(),
                'today' => ApiRequest::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count(),
            ]
        ]);
    }
}