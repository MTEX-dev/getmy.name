<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiRequest;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => ApiRequest::count(),
            'today' => ApiRequest::whereDate('created_at', Carbon::today())->count(),
        ];
        return view('stats.platform', compact('stats'));
    }

    public function getApiRequestData(Request $request)
    {
        $range = $request->get('range', '30d');
        
        $now = Carbon::now();
        $startDate = $now->copy()->subDays(29)->startOfDay(); // Default
        $endDate = $now->copy(); // Default end is now
        
        $unit = 'day';
        $format = 'Y-m-d';
        $step = 'addDay';

        if ($range === 'custom') {
            // Validate inputs, fallback to today if missing
            $fromInput = $request->get('from');
            $toInput = $request->get('to');

            $startDate = $fromInput ? Carbon::parse($fromInput) : $now->copy()->startOfDay();
            $endDate = $toInput ? Carbon::parse($toInput) : $now->copy()->endOfDay();

            // Auto-calculate Granularity based on difference
            $diffInHours = $startDate->diffInHours($endDate);
            $diffInDays = $startDate->diffInDays($endDate);

            if ($diffInHours <= 4) {
                // High precision for short windows
                $unit = 'minute';
                $format = 'Y-m-d H:i:00';
                $step = 'addMinute';
            } elseif ($diffInDays <= 7) {
                // Hourly for up to a week
                $unit = 'hour';
                $format = 'Y-m-d H:00:00';
                $step = 'addHour';
            } else {
                // Daily for anything longer
                $unit = 'day';
                $format = 'Y-m-d';
                $step = 'addDay';
            }

        } else {
            // Preset Logic
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
                    $unit = 'day'; // Explicitly set day
                    $format = 'Y-m-d';
                    $step = 'addDay';
                    break;
                case '90d':
                    $startDate = $now->copy()->subDays(89)->startOfDay();
                    $unit = 'day';
                    $format = 'Y-m-d';
                    $step = 'addDay';
                    break;
                case 'lifetime':
                    $firstReq = ApiRequest::oldest()->first();
                    $startDate = $firstReq ? $firstReq->created_at->startOfDay() : $now->copy()->subDays(30)->startOfDay();
                    $unit = 'day';
                    $format = 'Y-m-d';
                    $step = 'addDay';
                    break;
                case '30d':
                default:
                    $startDate = $now->copy()->subDays(29)->startOfDay();
                    $unit = 'day';
                    $format = 'Y-m-d';
                    $step = 'addDay';
                    break;
            }
        }

        // Build Query with strict range
        $query = ApiRequest::whereBetween('created_at', [$startDate, $endDate]);

        // Grouping Logic
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

        $labels = [];
        $counts = [];
        $current = $startDate->copy();
        
        // Safety limit to prevent infinite loops if dates are messed up
        $safety = 0;
        
        // Loop from Start to End
        while ($current <= $endDate && $safety < 2000) {
            $key = $current->format($unit === 'day' ? 'Y-m-d' : $format);
            $labels[] = $key;
            $counts[] = $dbData->get($key, 0);
            $current->$step();
            $safety++;
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'unit' => $unit,
            'stats' => [
                'total' => ApiRequest::count(),
                'today' => ApiRequest::whereDate('created_at', Carbon::today())->count(),
            ]
        ]);
    }
}