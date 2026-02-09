<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiRequest;
use App\Models\User;
use Carbon\Carbon;

class StatsController extends Controller
{
    /**
     * Display the stats page with the sidebar.
     */
    public function index($metric)
    {
        // define titles and descriptions
        $meta = match ($metric) {
            'users' => [
                'title' => 'User Registrations',
                'desc' => 'New user signups over time',
                'total_label' => 'Total Users',
                'today_label' => 'New Users Today'
            ],
            'api-requests' => [
                'title' => 'API Requests',
                'desc' => 'Global usage statistics across the platform',
                'total_label' => 'Lifetime Requests',
                'today_label' => 'Requests Today'
            ],
            default => abort(404)
        };

        // Get Model
        $model = $metric === 'users' ? User::class : ApiRequest::class;

        // Calculate initial card stats
        $stats = [
            'total' => $model::count(),
            'today' => $model::whereDate('created_at', Carbon::today())->count(),
        ];

        return view('stats.platform', compact('stats', 'metric', 'meta'));
    }

    /**
     * Generic Data Fetcher for Chart.js
     */
    public function getData(Request $request, $metric)
    {
        $range = $request->get('range', '30d');
        
        $now = Carbon::now();
        $startDate = $now->copy()->subDays(29)->startOfDay();
        $endDate = $now->copy();
        
        $unit = 'day';
        $format = 'Y-m-d';
        $step = 'addDay';

        // 1. Determine Date Range
        if ($range === 'custom') {
            $fromInput = $request->get('from');
            $toInput = $request->get('to');
            $startDate = $fromInput ? Carbon::parse($fromInput) : $now->copy()->startOfDay();
            $endDate = $toInput ? Carbon::parse($toInput) : $now->copy()->endOfDay();

            $diffInHours = $startDate->diffInHours($endDate);
            $diffInDays = $startDate->diffInDays($endDate);

            if ($diffInHours <= 4) {
                $unit = 'minute';
                $format = 'Y-m-d H:i:00';
                $step = 'addMinute';
            } elseif ($diffInDays <= 7) {
                $unit = 'hour';
                $format = 'Y-m-d H:00:00';
                $step = 'addHour';
            } else {
                $unit = 'day';
                $format = 'Y-m-d';
                $step = 'addDay';
            }
        } else {
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
                    // Select model for lifetime check
                    $m = $metric === 'users' ? User::class : ApiRequest::class;
                    $firstReq = $m::oldest()->first();
                    $startDate = $firstReq ? $firstReq->created_at->startOfDay() : $now->copy()->subDays(30)->startOfDay();
                    break;
                case '30d':
                default:
                    $startDate = $now->copy()->subDays(29)->startOfDay();
                    break;
            }
        }

        // 2. Build Query
        $model = $metric === 'users' ? User::class : ApiRequest::class;
        $query = $model::whereBetween('created_at', [$startDate, $endDate]);

        // 3. Grouping Logic
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
        $safety = 0;
        
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
                'total' => $model::count(),
                'today' => $model::whereDate('created_at', Carbon::today())->count(),
            ]
        ]);
    }
}