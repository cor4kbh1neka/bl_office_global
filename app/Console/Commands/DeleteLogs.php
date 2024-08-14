<?php

namespace App\Console\Commands;

use App\Models\ListError;
use App\Models\LogBank;
use App\Models\LogMember;
use Illuminate\Console\Command;

class DeleteLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tgldari = date('Y-m-d') . ' 00:00:00';
        $tglhingga = date('Y-m-d', strtotime('-30 days')) . ' 23:59:59';

        LogBank::whereBetween('created_at', [$tglhingga, $tgldari])->delete();
        LogMember::whereBetween('created_at', [$tglhingga, $tgldari])->delete();
        ListError::whereBetween('created_at', [$tglhingga, $tgldari])->delete();

        $this->info('Old records deleted successfully.');

        return 0;
    }
}
