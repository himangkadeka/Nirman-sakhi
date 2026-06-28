<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $table = 'Benefit.benefits';

    protected $fillable = [
        'name',
        'benefit_code',
        'description',
        'status',
        'role_ids',
        'maximum_applications_per_worker',
        'category_id'
    ];

    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }

    public function formSubmissions()
    {
        return $this->hasMany(FormSubmission::class);
    }


    public function isAccessibleByWorker($workerData): bool
    {
        // If role_ids is null or empty, the benefit is open to everyone.
        if (empty($this->role_ids)) {
            return true;
        }

        // IMPORTANT: Assuming the worker's role is stored in $workerData->role_id
        // If the worker has no role, they cannot access a restricted benefit.
        if (empty($workerData->role_id)) {
            return false;
        }

        // Convert the comma-separated string of allowed roles into an array.
        $allowedRoles = explode(',', $this->role_ids);

        // Check if the worker's role ID exists in the array of allowed roles.
        // The trim is important to handle spaces like "6, 7, 8".
        return in_array($workerData->role_id, array_map('trim', $allowedRoles));
    }


    public function hasReachedApplicationLimit(int $workerId): bool
    {
        // If the limit is not set (null or 0), it means unlimited applications are allowed.
        // if (empty($this->maximum_applications_per_worker)) {
        //     return false; // They have NOT reached the limit.
        // }

        // Count only the applications that are submitted and not in a draft/reverted state.
        $completedApplicationsCount = FormSubmission::where('worker_id', $workerId)
            ->where('benefit_id', $this->id)
            ->whereNotNull('status') // Excludes new applications where status is NULL
            ->whereNotIn('status', ['draft', 'reverted']) // Excludes drafts and reverted ones
            ->count();

        // Return true if their count is greater than or equal to the allowed maximum.
        return $completedApplicationsCount >= $this->maximum_applications_per_worker;
    }
}
