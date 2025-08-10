<?php

namespace App\Console\Commands;

use App\Models\MigrationLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateTransaction extends Command
{
    protected $signature = 'transaction:migrate {--date=}';
    protected $description = 'Migrate transaction data between date ranges from the "now" database to the "old" database';

    public function handle()
    {
        $date = $this->option('date');

         // Validasi format tanggal
        if (!$date) {
            $this->error('Please provide a date using --date=YYYY-MM-DD');
            return 1;
        }

        if (!Carbon::hasFormat($date, 'Y-m-d')) {
            $this->error("❌ Invalid date format. Use YYYY-MM-DD.");
            return;
        }

         $log = MigrationLog::create([
            'date' => $date,
            'status' => 'running',
            'message' => '',
        ]);

        if (!$log) {
            Log::channel('error-custom-logs')->error('Failed to insert migration log.');
            $this->error("❌ Migration failed: cannot insert log.");
            return;
        }

        $tables = [
            'history_transaksi',
            'depo_wd'
        ];

        try {
            $this->info("📦 Starting daily migration for $date...");

            DB::beginTransaction();
            DB::connection('mysql_old')->beginTransaction();

            foreach ($tables as $table) {
                $this->info("➡️ Migrating table `$table`...");

                $rows = DB::connection('mysql')->table($table)
                    ->whereDate('created_at', $date)
                    ->get();

                $count = $rows->count();

                if ($count === 0) {
                    $this->warn("⚠️ No data for $table on $date.");
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

                // Cek apakah jumlah record sesuai
                $countAfter = DB::connection('mysql_old')->table($table)
                    ->whereDate('created_at', $date)
                    ->count();

                if ($countAfter < $count) {
                    throw new \Exception("❌ $table: record mismatch after insert ($count vs $countAfter).");
                }

                // Hapus dari DB utama
                // DB::connection('mysql')->table($table)
                //     ->whereDate('created_at', $date)
                //     ->delete();

                $this->info("✅ $table migrated successfully.");
            }

            DB::commit();
            DB::connection('mysql_old')->commit();

            // Update log sukses
            $log->update([
                'status' => 'success',
                'message' => "✅ All tables migrated for $date.",
            ]);

            $this->info("🎉 Migration completed for all tables on $date.");
        } catch (\Exception $e) {
            DB::rollBack();
            DB::connection('mysql_old')->rollBack();

            // Update log gagal
            $log->update([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);

            Log::channel('error-custom-logs')->error('Migration exception:', [
                'error' => $e->getMessage(),
            ]);

            $this->error("❌ Migration failed: " . $e->getMessage());
        }

        return 0;
    }

}
