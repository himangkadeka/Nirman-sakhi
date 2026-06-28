<?php

namespace App\Http\Controllers\Admin\errorlogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiLog;
use Illuminate\Support\Facades\DB;

class UanErrorLogsController extends Controller
{

    public function index()
    {
        // Example: Total logs
        $totalLogs = ApiLog::count();
        $showLogs = ApiLog::orderBy('created_at', 'asc')->paginate(10);
//
//        // Example: Successful logs
//        $successLogs = ApiLog::where('status', 'success')->count();
//
//        // Example: Error logs
//        $failedLogs = ApiLog::where('status', 'failed')->count();

        // Example: Endpoint wise summary
        $endpointSummary = ApiLog::select('endpoint', DB::raw('COUNT(*) as total'))
            ->groupBy('endpoint')
            ->get();

        return view('admin.mis-data.error-logs-uan.error-logs-api', compact(
            'totalLogs',
            'endpointSummary',
            'showLogs'
        ));
    }

}
