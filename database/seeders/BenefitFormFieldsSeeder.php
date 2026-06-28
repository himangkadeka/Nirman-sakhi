<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BenefitFormFieldsSeeder extends Seeder
{
    public function run()
    {
        DB::table('Benefit.form_fields')->truncate();

        $csvFilePath = public_path('app/database_file/form_fields.csv');
        $csv = array_map('str_getcsv', file($csvFilePath));
        $headers = array_shift($csv);
        $selectedHeaders = [
            "benefit_id", "name", "type", "masterdata_table", "use_masterdata",
            "masterdata_table_key", "masterdata_table_value", "masterdata_table_condition",
            "validation_rules", "error_messages", "options", "order", "use_prefilled_data",
            "prefilled_data_type", "prefilled_vault_data_key", "prefilled_worker_data_table",
            "prefilled_worker_data_key", "use_masterdata_value", "masterdata_value_table",
            "masterdata_value_table_key", "masterdata_value_table_value", "is_required",
            "is_readonly", "is_hidden", "is_disabled", "is_dependent_field",
            "dependent_field_id", "dependent_field_value", "status", "created_at",
            "updated_at", "deleted_at"
        ];

        foreach ($csv as $row) {
            // Skip the first column (id) from each row
            $rowWithoutId = array_slice($row, 1);

            // Check if the remaining columns match your selected headers count
            if (count($selectedHeaders) !== count($rowWithoutId)) {
                throw new \Exception("CSV column mismatch: " . json_encode($rowWithoutId));
            }

            // Combine only selected headers with row data (without id)
            $assoc = array_combine($selectedHeaders, $rowWithoutId);

            // Normalize data types
            $data = array_map(function ($value) {
                $value = trim($value, "\"");

                if (strtoupper($value) === 'NULL') return null;
                if (strtolower($value) === 'true') return true;
                if (strtolower($value) === 'false') return false;

                return $value;
            }, $assoc);

            // Add timestamps
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('Benefit.form_fields')->insert($data);
        }
    }
}
