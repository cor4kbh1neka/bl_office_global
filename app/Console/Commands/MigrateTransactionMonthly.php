<?php

namespace App\Console\Commands;

use App\Models\MigrationLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateTransactionMonthly extends Command
{
    protected $signature = 'transactionmonth:migrate {--month=}';
    protected $description = 'Migrate 1 day of transaction data from the "now" database to the "old" database';


    public function handle()
    {
        $targetMonth = $this->option('month') ?? Carbon::now()->subMonths(4)->format('Y-m');
        [$year, $month] = explode('-', $targetMonth);

        // Cek apakah ada log yang masih running/success untuk bulan ini
        // $dataLogs = MigrationLog::where('date', $targetMonth)
        //     ->whereIn('status', ['running', 'success'])
        //     ->first();

        // if ($dataLogs) {
        //     Log::channel('error-custom-logs')->error("Data logs for $targetMonth already running or done.");
        //     $this->error("❌ Migration failed: logs for $targetMonth already exist.");
        //     return;
        // }

        // $createLogId = DB::table('migration_logs')->insertGetId([
        //     'target_month' => $targetMonth,
        //     'status' => 'running',
        //     'message' => '',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // if (!$createLogId) {
        //     Log::channel('error-custom-logs')->error('Failed to insert migration log.');
        //     $this->error("❌ Migration failed: cannot insert log.");
        //     return;
        // }

        $tables = [
            'history_transaksi',
            'depo_wd'
        ];

        try {
            $this->info("📦 Starting multi-table migration for $targetMonth...");

            DB::beginTransaction();
            DB::connection('mysql_old')->beginTransaction();

            foreach ($tables as $table) {
                $this->info("➡️ Migrating table `$table`...");

                DB::connection('mysql_old')->table($table)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->delete();

                $rows = DB::connection('mysql')->table($table)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->get();

                $count = $rows->count();

                if ($count === 0) {
                    $this->warn("⚠️ No data for $table in $targetMonth.");
                    continue;
                }

                $this->info("🔁 Migrating $count records from $table...");
                $progress = $this->output->createProgressBar($count);
                $progress->start();

                foreach ($rows as $row) {
                    DB::connection('mysql_old')->table($table)->insert((array) $row);
                    $progress->advance();
                }

                $progress->finish();
                $this->newLine();

                $countAfter = DB::connection('mysql_old')->table($table)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();

                if ($countAfter < $count) {
                    throw new \Exception("❌ $table: record mismatch after insert ($count vs $countAfter).");
                }

                // DB::connection('mysql')->table($table)
                //     ->whereYear('created_at', $year)
                //     ->whereMonth('created_at', $month)
                //     ->delete();

              
                $this->info("✅ $table migrated successfully.");
            }

            DB::commit();
            DB::connection('mysql_old')->commit();

            // DB::table('migration_logs')->where('id', $createLogId)->update([
            //     'status' => 'success',
            //     'message' => "✅ All tables migrated for $targetMonth.",
            //     'updated_at' => now(),
            // ]);

            $this->info("🎉 Migration completed for all tables in $targetMonth.");
        } catch (\Exception $e) {
            DB::rollBack();
            DB::connection('mysql_old')->rollBack();

            // DB::table('migration_logs')->where('id', $createLogId)->update([
            //     'status' => 'failed',
            //     'message' => $e->getMessage(),
            //     'updated_at' => now(),
            // ]);

            Log::channel('error-custom-logs')->error('Migration exception:', [
                'error' => $e->getMessage(),
            ]);

            $this->error("❌ Migration failed: " . $e->getMessage());
        }

        return 0;
    }

}
