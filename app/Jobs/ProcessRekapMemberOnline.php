<?php

namespace App\Jobs;

use App\Models\RekapDashboardDay;
use App\Models\RekapMemberOnline;
use App\Models\TransactionSaldo;
use App\Models\TransactionStatus;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessRekapMemberOnline implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data; 
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $username = $this->data['username'];

            $yesterday = Carbon::yesterday()->format('Y-m-d');
            RekapMemberOnline::whereDate('created_at', $yesterday)->delete();

            $dataRekapUsername = RekapMemberOnline::where('username', $username)->first();

            if(!$dataRekapUsername) {
                $rekap = RekapMemberOnline::create([
                    'username' => $username
                ]);

                if ($rekap) {
                    // Log::info('Data RekapMemberOnline berhasil dibuat untuk username: ' . $username);
                    $this->updateRekapDashboard();
                } 
            } 

           
        } catch (\Exception $e) {
            Log::error('ProcessRekapMemberOnline failed: ' . $e->getMessage(), [
                'data' => $this->data,
                'trace' => $e->getTraceAsString()
            ]);

            // throw $e;
        }
    }

    private function updateRekapDashboard()
    {
        DB::transaction(function () {
            $existsToday = RekapDashboardDay::whereDate('created_at', Carbon::today())->first();

            if (!$existsToday) {
                $existsToday = RekapDashboardDay::create([
                    'created_at' => Carbon::now()
                ]);
            }

            $existsToday->increment('member_online', 1);
        });
    }
}
