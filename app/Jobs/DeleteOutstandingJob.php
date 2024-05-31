<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Outstanding;

class DeleteOutstandingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $transfercode;
    /**
     * Create a new job instance.
     */
    public function __construct(string $transfercode)
    {
        $this->transfercode = $transfercode;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Outstanding::where('transfercode', $this->transfercode)->delete();
    }
}
