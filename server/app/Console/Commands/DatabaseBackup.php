<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database backup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $batchNumber = DB::table('migrations')->select('batch')->get()->max('batch');
        $filename    = 'backup_' . Carbon::now()->format('Y_m_d_H_i') . '_batch_' . str_pad($batchNumber, 2, '0', STR_PAD_LEFT) . '.sql';

        // Backup Mysql Database
        if (config('database.default') == 'mysql') {
            $command = '' . config('database.dump_path')
            . ' --user=' . config('database.connections.mysql.username')
            . ' --password=' . config('database.connections.mysql.password')
            . ' --host=' . config('database.connections.mysql.host')
            . ' ' . config('database.connections.mysql.database')
            . '  > ' . storage_path()
            . '/app/backup/' . $filename;

            $returnVar = NULL;
            $output = NULL;

            exec($command, $output, $returnVar);
        } else {
            Log::error('Backup not configured for the selected database.');
        }
    }
}
