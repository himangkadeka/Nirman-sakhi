<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Masterdata.reasons')->truncate();
        DB::table('Masterdata.reasons')->insert([
            // Reasons for Reverting Applications
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Uploaded document(s) not clearly visible.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Uploaded document(s) are incorrect.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Uploaded document(s) are incomplete.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Details mentioned in the documents are incorrect.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Document(s) not uploaded under the correct field(s).', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Fake document(s) uploaded.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Details mentioned in the form are not matching with the document(s).', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Some important fields are missing in the form.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Some important document(s) are not uploaded.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Fake acknowledgement slip (with registration fee mentioned)- Only for new registrations bypassing the registration fee payment.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Correct BOCW ID Card not uploaded.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Correct Subscription payment receipt is not uploaded.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => '90 Days certificate not uploaded in correct format.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Uploaded document(s) not clearly visible.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Uploaded document(s) are incorrect.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Uploaded document(s) are incomplete.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Details mentioned in the documents are incorrect.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Document(s) not uploaded under the correct field(s).', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Fake document(s) uploaded.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Details mentioned in the form are not matching with the document(s).', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Some important fields are missing in the form.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Some important document(s) are not uploaded.', 'created_at' => now(), 'updated_at' => now()],
           

            // Reasons for Rejecting Applications
            ['type' => 'Reject', 'category' => 'New Registration', 'reason' => 'Information provided is found to be incorrect after verification.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Reject', 'category' => 'New Registration', 'reason' => 'Fake document(s) uploaded.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Reject', 'category' => 'New Registration', 'reason' => '90 Days certificate not uploaded in correct format.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Reject', 'category' => 'Onboarding', 'reason' => 'Name,gender and Date of Birth in uploaded BOCW ID Card is not matching with Aadhaar data.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Reject', 'category' => 'Renewal', 'reason' => 'Information provided is found to be incorrect after verification.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Reject', 'category' => 'Renewal', 'reason' => 'Fake document(s) uploaded.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'Onboarding', 'reason' => 'Wrong informations provided.', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Revert', 'category' => 'New Registration', 'reason' => 'Wrong informations provided.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
