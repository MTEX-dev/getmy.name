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
        $user = Auth::user();
        $stats = [
            'total' => ApiRequest::where('user_id', $user->id)->count(),
            'today' => ApiRequest::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count(),
        ];
        return view('profile.api-requests', compact('stats'));
    }

    public function getApiRequestData(Request $request)
    {
        $user = Auth::user();
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
                $firstReq = ApiRequest::where('user_id', $user->id)->oldest()->first();
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

        $query = ApiRequest::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate);

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
                'total' => ApiRequest::where('user_id', $user->id)->count(),
                'today' => ApiRequest::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count(),
            ]
        ]);
    }
}