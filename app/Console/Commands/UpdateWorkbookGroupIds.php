<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WorkbookModel;

class UpdateWorkbookGroupIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workbook:update-group-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate group_id and sub_row_id from row_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating workbook rows...');

        WorkbookModel::whereNull('group_id')
            ->select('id', 'row_id')
            ->chunkById(200, function ($rows) {

                foreach ($rows as $row) {

                    $rowId = trim((string) $row->row_id);

                    if ($rowId === '' || $rowId === null) {
                        continue;
                    }

                    if (str_contains($rowId, '.')) {

                        [$groupId, $subRowId] = explode('.', $rowId);

                        $groupId = (int) $groupId;
                        $subRowId = (int) $subRowId;

                    } else {

                        $groupId = (int) $rowId;
                        $subRowId = 0;
                    }

                    WorkbookModel::where('id', $row->id)->update([
                        'group_id'   => $groupId,
                        'sub_row' => $subRowId,
                    ]);
                }
            });

        $this->info('Workbook update completed.');

        return Command::SUCCESS;
    }
}