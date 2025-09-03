<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageController extends Controller
{
    public function lander()
    {
        return view("pages.lander");
    }

    public function dashboard()
    {
        $user = auth()->user();
        $days = 30;
        
        $requestsOverTime = ApiRequest::where('user_id', $user->id)
            ->where('requested_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw('DATE(requested_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topRoutes = ApiRequest::where('user_id', $user->id)
            ->where('requested_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw('request_url, COUNT(*) as count')
            ->groupBy('request_url')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $methodStats = ApiRequest::where('user_id', $user->id)
            ->where('requested_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw('request_method, COUNT(*) as count')
            ->groupBy('request_method')
            ->get();

        $dates = collect();
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = $requestsOverTime->where('date', $date)->first()->count ?? 0;
            $dates->push([
                'date' => $date,
                'count' => $count
            ]);
        }

        return view('dashboard', compact('dates', 'topRoutes', 'methodStats', 'days'));
    }
}