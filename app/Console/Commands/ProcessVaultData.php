<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\MISData\BulkVaultDataController;
use Illuminate\Console\Command;

class ProcessVaultData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault:process {limit=500}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process vault data in batches until finished';

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
        $controller = app(BulkVaultDataController::class);
        $limit = $this->argument('limit');

        $this->info("Starting Vault Verification...");

        while (true) {
            $this->info("Processing batch of $limit...");

            // Call the logic directly (offset 0 because we filter out verified records in the query)
            $response = $controller->performVerification($limit, 0);
            $content = json_decode($response->getContent(), true);

            if ($content['status'] === 'success') {
                $left = $content['data']['total_left_to_do'];
                $this->info("Batch Done. Verified: {$content['data']['total_verified']}. Remaining: $left");

                if ($left <= 0) {
                    $this->info("All records processed!");
                    break;
                }

                // Optional: Wait 1 second to prevent server overload
                sleep(1);
            } else {
                $this->error("Error: " . $content['message']);
                break;
            }
        }
    }
}
