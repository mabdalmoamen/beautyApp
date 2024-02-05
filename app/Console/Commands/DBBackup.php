<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Service\TenantServcie;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DBBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DB:BackUp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if (\Config::get('database.default') != strtolower('mysql')) {
            $tenants = Tenant::get();
            $tenants->each(
                function ($tenant) {
                    (new TenantServcie)->switchToTenant($tenant);
                    $filename = "backup-Codies" . $tenant->database . "_" . Carbon::now()->format('Y-m-d') . ".sql";
                    $command = "mysqldump.exe --no-defaults -uroot -pDb2@dm1n2022 --databases --add-drop-database " . $tenant->database . "  > " . base_path() . "/app/backup/" . $filename;
                    $returnVar = NULL;
                    $output  = NULL;
                    exec($command, $output, $returnVar);
                }
            );
        } else {
            $filename = "backup-Codies" . Carbon::now()->format('Y-m-d') . ".sql";
            $command = "mysqldump.exe --no-defaults -uroot -pDb2@dm1n2022 --databases --add-drop-database codies  > " . base_path() . "/app/backup/" . $filename;
            $returnVar = NULL;
            $output  = NULL;
            exec($command, $output, $returnVar);
        }
    }
}
