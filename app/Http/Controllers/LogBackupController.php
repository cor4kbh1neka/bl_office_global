<?php

namespace App\Http\Controllers;

use App\Models\LogBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LogBackupController extends Controller
{
    public function index(Request $request)
    {
        $data = LogBackup::orderBy('created_at', 'desc')->paginate(10);
        return view('logbackup.index', [
            'title' => 'List Log Backup',
            'data' => $data
        ]);
    }

    public function jobmonitoring()
    {
        $data = DB::table('jobs')->orderBy('created_at', 'desc')->paginate(10);
        $countDataJob = DB::table('jobs')->count();
        $countDataFailJob = DB::table('failed_jobs')->count();

        return view('logbackup.jobmonitoring', [
            'title' => 'Job Monitoring',
            'data' => $data,
            'countDataJob' => $countDataJob,
            'countDataFailJob' => $countDataFailJob
        ]);
    }

    public function failjobmonitoring()
    {
        $data = DB::table('failed_jobs')->orderBy('created_at', 'desc')->paginate(10);
        $countDataJob = DB::table('jobs')->count();
        $countDataFailJob = DB::table('failed_jobs')->count();

        return view('logbackup.failjobmonitoring', [
            'title' => 'Job Monitoring',
            'data' => $data,
            'countDataJob' => $countDataJob,
            'countDataFailJob' => $countDataFailJob
        ]);
    }

    public function historylog(Request $request)
    {
        $selectedFile = $request->input('logFile');

        $logFiles = collect(File::files(storage_path('logs')))
        ->filter(function ($file) {
            $name = $file->getFilename();
            return $name === 'laravel.log' || str_contains($name, 'error-custom-logs.log') || str_contains($name, 'error-custom-ws-logs.log') || str_contains($name, 'error-custom-ws-ball-logs.log');
        })
        ->map(function ($file) {
            return $file->getFilename();
        })
        ->sort()
        ->values();

        $activeLogFile = $selectedFile ?? $logFiles->last();
        $logPath = storage_path('logs/' . $activeLogFile);

        $logs = File::exists($logPath) ? File::get($logPath) : 'Log file not found.';

        return view('logbackup.historylog', [
            'title' => 'Custom Log Monitor',
            'logs' => $logs,
            'logFile' => $activeLogFile,
            'availableLogs' => $logFiles,
        ]);
    }

    public function clear(Request $request)
    {
        $logFile = $request->input('logFile');
        $logPath = storage_path('logs/' . $logFile);

        if (File::exists($logPath)) {
            File::put($logPath, ''); 
        }

        return redirect('/historylog?logFile=' . urlencode($logFile))
            ->with('status', "Log {$logFile} berhasil dikosongkan.");
    }
}
