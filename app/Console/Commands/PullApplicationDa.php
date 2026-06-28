<?php

namespace App\Console\Commands;

use App\Services\ApplicationService;
use Illuminate\Console\Command;

class PullApplicationDa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:pull-application-da';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pull application from da';

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

        $ApplicationService = new ApplicationService();
        $result = $ApplicationService->updateApplicationStatus();
        $this->info($result);
    }
}
