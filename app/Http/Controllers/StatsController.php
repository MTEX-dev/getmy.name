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
        $unit = 'day';

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
                $format = 'Y-m-d';
                $step = 'addDay';
                break;
            case '90d':
                $startDate = $now->copy()->subDays(89)->startOfDay();
                $format = 'Y-m-d';
                $step = 'addDay';
                break;
            case 'lifetime':
                // Get oldest request from ANY user
                $firstReq = ApiRequest::oldest()->first();
                $startDate = $firstReq ? $firstReq->created_at->startOfDay() : $now->copy()->subDays(30)->startOfDay();
                $format = 'Y-m-d';
                $step = 'addDay';
                break;
            case '30d':
            default:
                $startDate = $now->copy()->subDays(29)->startOfDay();
                $format = 'Y-m-d';
                $step = 'addDay';
                break;
        }

        $query = ApiRequest::where('created_at', '>=', $startDate);

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

        while ($current <= $now) {
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
                'total' => ApiRequest::count(),
                'today' => ApiRequest::whereDate('created_at', Carbon::today())->count(),
            ]
        ]);
    }
}