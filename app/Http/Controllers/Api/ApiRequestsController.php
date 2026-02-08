<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiRequestsController extends Controller
{
    public function getAuthUserStats(Request $request)
    {
        return $this->generateStats($request, Auth::id());
    }
    public function getUserStats(Request $request, string $username)
    {
        //$user = User::where('username' === $username)->get();
        $user = User::where('username', $username)->firstOrFail();
        return $this->generateStats($request, $user->id);
    }

    public function getPlatformStats(Request $request)
    {
        return $this->generateStats($request, null);
    }

    private function generateStats(Request $request, $userId = null)
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
                $query = ApiRequest::query();
                if ($userId) {
                    $query->where('user_id', $userId);
                }
                $firstReq = $query->oldest()->first();
                $startDate = $firstReq
                    ? $firstReq->created_at->startOfDay()
                    : $now->copy()->subDays(30)->startOfDay();
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

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($unit === 'minute') {
            $dbData = $query
                ->selectRaw(
                    "DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:00') as timeframe, COUNT(*) as count"
                )
                ->groupBy('timeframe')
                ->pluck('count', 'timeframe');
        } elseif ($unit === 'hour') {
            $dbData = $query
                ->selectRaw(
                    "DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as timeframe, COUNT(*) as count"
                )
                ->groupBy('timeframe')
                ->pluck('count', 'timeframe');
        } else {
            $dbData = $query
                ->selectRaw('DATE(created_at) as timeframe, COUNT(*) as count')
                ->groupBy('timeframe')
                ->pluck('count', 'timeframe');
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

        $summaryQuery = ApiRequest::query();
        if ($userId) {
            $summaryQuery->where('user_id', $userId);
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'unit' => $unit,
            'scope' => $userId ? 'user' : 'platform',
            'stats' => [
                'total' => (clone $summaryQuery)->count(),
                'today' => (clone $summaryQuery)
                    ->whereDate('created_at', Carbon::today())
                    ->count(),
            ],
        ]);
    }
}