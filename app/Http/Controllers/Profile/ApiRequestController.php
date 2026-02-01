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
            'today' => ApiRequest::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count(),
        ];
        return view('profile.api-requests', compact('stats'));
    }

    public function getApiRequestData(Request $request)
    {
        $user = Auth::user();
        $range = $request->get('range', '30d');
        
        $endDate = Carbon::now();
        $unit = 'day';

        switch ($range) {
            case '1h':
                $startDate = Carbon::now()->subHour();
                $unit = 'minute';
                break;
            case '24h':
                $startDate = Carbon::now()->subDay();
                $unit = 'hour';
                break;
            case '7d':
                $startDate = Carbon::now()->subDays(6);
                break;
            case '90d':
                $startDate = Carbon::now()->subDays(89);
                break;
            case 'lifetime':
                $firstReq = ApiRequest::where('user_id', $user->id)->oldest()->first();
                $startDate = $firstReq ? $firstReq->created_at : Carbon::now()->subDays(30);
                break;
            case '30d':
            default:
                $startDate = Carbon::now()->subDays(29);
                break;
        }

        $query = ApiRequest::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate);

        if ($unit === 'minute') {
            $data = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:00') as timeframe, COUNT(*) as count")
                ->groupBy('timeframe')->pluck('count', 'timeframe');
        } elseif ($unit === 'hour') {
            $data = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as timeframe, COUNT(*) as count")
                ->groupBy('timeframe')->pluck('count', 'timeframe');
        } else {
            $data = $query->selectRaw("DATE(created_at) as timeframe, COUNT(*) as count")
                ->groupBy('timeframe')->pluck('count', 'timeframe');
        }

        return response()->json([
            'labels' => $data->keys(),
            'counts' => $data->values(),
            'unit' => $unit
        ]);
    }
}