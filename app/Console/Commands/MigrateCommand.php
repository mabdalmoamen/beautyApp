<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Service\TenantServcie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allDb:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'allDb migration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $allDb = Tenant::get();
        $allDb->each(function ($tenant) {
            if (str_starts_with($tenant->domain, 'beautytoday')) {
                (new TenantServcie)->switchToTenant($tenant);

                $this->info('Start updateing : ' . $tenant->domain);
                $this->info('---------------------------------------');
                DB::unprepared("ALTER TABLE
    `customers` CHANGE COLUMN `points` `points` DOUBLE NULL DEFAULT '0';

ALTER TABLE `mixins_info`
ADD
    COLUMN `bill_lang` VARCHAR(45) NULL DEFAULT 'ar' AFTER `active_point`;

ALTER TABLE `mixins_info`
ADD
    COLUMN `mixins_background` VARCHAR(255) NULL AFTER `bill_lang`;
");
                $this->info('Done');
            }
        });
        return Command::SUCCESS;
    }
}
