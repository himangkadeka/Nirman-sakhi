<?php

namespace App\Exports;

use App\Models\FormSubmission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

// We add WithHeadings, WithMapping, and ShouldAutoSize to add more features
class PpaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $applicationIds;

    // Use the constructor to accept the IDs
    public function __construct($applicationIds)
    {
        $this->applicationIds = $applicationIds;
    }
    /**
    * 1. The Collection: This method fetches the specific data we need.
    *
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        // IMPORTANT: Instead of FormSubmission::all(), we filter to get only
        // the applications ready for payment processing (PPA).
        return FormSubmission::with(['worker.districtName','worker.bankDetail', 'benefit']) // Eager load for performance
            ->whereIn('id', $this->applicationIds)
            ->orderBy('submitted_at', 'asc') // Good practice to have a consistent order
            ->get(); // FromCollection requires you to end with ->get()
    }

    /**
    * 2. The Headings: This defines the header row of the Excel file.
    */
    public function headings(): array
    {
        return [
            'Full Name in English',
            'Full Name in Recognized Official',
            'Gender',
            'Address1',
            'Address2',
            'District',
            'State',
            'Country',
            'Bank Name',
            'IFSC Code',
            'Account Number',
            'PIN',
            'Scheme',
            'Center Share Payment Amount',
            'State Share Payment Amount',
        ];
    }

    /**
    * 3. The Mapping: This method transforms each application model into an array
    *    that matches the order of the headings.
    *
    * @param FormSubmission $submission The application instance from the collection.
    */
    public function map($submission): array
    {
        // Get the related worker model for easier access
        $worker = $submission->worker;

        // **IMPORTANT**: Adjust these fields to match your actual database columns
        // on the 'workers' table. I am using placeholders.
        // Example logic for splitting the sanctioned amount (e.g., 60% Center, 40% State)
        $centerShare = $submission->sanctioned_amount * 0.60;
        $stateShare  = $submission->sanctioned_amount * 0.40;

        return [
            $worker->fullname_english ?? 'N/A',
            $worker->fullname_regional ?? 'N/A', // Placeholder for regional language name
            $worker->gender ?? 'N/A',
            $worker->address_1 ?? 'N/A',       // Placeholder for address line 1
            $worker->address_2 ?? 'N/A',       // Placeholder for address line 2
            $worker->districtName->district_name ?? 'N/A',  // Accessing the name from the eager-loaded relationship
            $worker->districtName->state->name ?? 'N/A',     // Accessing the name from the eager-loaded relationship
            'India',                           // Assuming this is a constant value
            $worker->bankDetail->bank_name ?? 'N/A',       // Placeholder
            $worker->bankDetail->ifsc_code ?? 'N/A',       // Placeholder
            $worker->bankDetail->account_no ?? 'N/A',      // Placeholder
            $worker->pincode ?? 'N/A',         // Placeholder
            $submission->benefit->name ?? 'N/A',
            number_format($centerShare, 2, '.', ''), // Format to 2 decimal places without thousand separators
            number_format($stateShare, 2, '.', ''),  // Format to 2 decimal places
        ];
    }
}
