<?php

namespace App\Console\Commands;

use App\Models\MainWorkerForm;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class checkQuarterlySubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workers:activeStatus';

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
        $currentDate = Carbon::now()->format('d-m-y');
        $workers = MainWorkerForm::where('subscription_status','quarterly')->get();
        foreach ($workers as $worker){
            $expiryDate = Carbon::parse($worker->expiry_date);
            $quarters = round($expiryDate->diffInMonths($currentDate) / 3);
            if ($quarters>0){
                MainWorkerForm::where('worker_id',$worker->worker_id)->update([
                    'active_status'=>0
                ]);
            }
            \Log::info($quarters);
        }
    }
}
