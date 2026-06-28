<?php

namespace App\Exports;

use App\Models\FormSubmission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AccountsApplicationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * 1. The Collection: This method runs the aggregate query to get the summary data.
    */
    public function collection(): Collection
    {
        return FormSubmission::join('Benefit.benefits', 'Benefit.form_submissions.benefit_id', '=', 'benefits.id')
            ->where('form_submissions.status', 'forwarded_to_accounts')
            ->select(
                'benefits.name as scheme_name',
                DB::raw('SUM(form_submissions.sanctioned_amount) as total_budget')
            )
            ->groupBy('benefits.name')
            ->orderBy('scheme_name')
            ->get();
    }

    /**
    * 2. The Headings: Defines the header row for the summary Excel file.
    */
    public function headings(): array
    {
        return [
            'Scheme Name',
            'Total Sanctioned Amount',
        ];
    }

    /**
    * 3. The Mapping: Formats each row of the summary data.
    *
    * @param mixed $summaryRow The result row from the collection.
    */
    public function map($summaryRow): array
    {
        return [
            $summaryRow->scheme_name,
            number_format($summaryRow->total_budget, 2, '.', ''), // Format as a number with 2 decimal places
        ];
    }
}
