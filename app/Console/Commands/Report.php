<?php

namespace App\Console\Commands;

use App\Mail\ReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Mixins;
use App\Models\Tenant;
use App\Service\TenantServcie;

class Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:Report';

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
        // if (\Config::get('database.default') != strtolower('mysql')) {
        //     $tenants = Tenant::get();
        //     $tenants->each(
        //         function ($tenant) {
        //             (new TenantServcie)->switchToTenant($tenant);

        //             $email_to = Mixins::select('email_to')->where('id', 1)->first();
        //             $this->info('Start updateing : ' . $email_to->email_to);
        //             $this->info('---------------------------------------');

        //             Mail::to($email_to->email_to)->send(new ReportMail());
        //             $this->info('Done');

        //         }
        //     );
        // } else {

        $email_to = Mixins::select('email_to')->where('id', 1)->first();
        Mail::to($email_to->email_to)->send(new ReportMail());
        // }
    }
}
