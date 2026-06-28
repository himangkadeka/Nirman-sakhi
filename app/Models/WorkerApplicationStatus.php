<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class WorkerApplicationStatus extends Model
{
    use HasFactory;
    protected $table = 'Worker.worker_application_statuses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'office_id',
        'worker_id',
        'application_no',
        'ack_no',
        'application_status',
        'remarks',
        'sender_role_id',
        'sender_office_id',
        'sender_user_id'
        ,
        'application_from_user',
        'service_id',
        'application_receiver_user_id',
        'expiry',
        'revert_back',
        'pull_back',
        'application_receiver_role_id',
        'ro_approval_time',
        'forward_to_da',
        'forward_to_ro',
        'is_renewal',
        're_route',
        're_route_time',
        'reasons',
        'resubmit_status',
        'already_registered',
        'da_forward'
    ];


    public function mainWorker()
    {
        return $this->belongsTo(MainWorkerForm::class, 'worker_id', 'worker_id');
    }
    public function getApplicationStatus($worker_id, $application_status)
    {

        $data = MainWorkerForm::where('worker_id', $worker_id)->where('status', $application_status)->latest()->first();
        return $data;
    }

    public function latestStatusRelation()
    {
        return $this->hasOne(WorkerApplicationStatus::class, 'worker_id', 'worker_id')->where('is_renewal',1)
            ->latestOfMany();
    }

    // ADD THIS NEW RELATIONSHIP
    public function applicationFromUser()
    {
        return $this->belongsTo(User::class, 'application_from_user', 'id');
    }

    // ADD THIS ACCESSOR METHOD
    public function getFromUserDisplayNameAttribute()
    {
        // If application_from_user is numeric, it's a user ID - use relationship
        if (is_numeric($this->application_from_user)) {
            $user = $this->applicationFromUser;
            if ($user) {
                return trim($user->firstname . ' ' . $user->lastname);
            }
            return 'User ID: ' . $this->application_from_user;
        }

        // Otherwise it's already a username string
        return $this->application_from_user ?? 'N/A';
    }

    // Add alongside your existing applicationFromUser()
public function applicationReceiverUser()
{
    return $this->belongsTo(User::class, 'application_receiver_user_id', 'id');
}

    public function getReasons()
    {
        // Ensure the reasons field is not null or empty
        if (empty($this->reasons)) {
            return collect(); // Return an empty collection
        }

        // Explode the comma-separated reason IDs into an array
        $reason_ids_array = array_filter(explode(',', $this->reasons));

        // Ensure the array has valid IDs
        if (empty($reason_ids_array)) {
            return collect(); // Return an empty collection
        }

        // Fetch the corresponding reason objects from the Reason table
        $reasons = Reasons::whereIn('id', $reason_ids_array)->get();

        return $reasons;
    }

    public function getMappedRemarksAttribute()
    {
        if (blank($this->reasons)) {
            return collect();
        }

        $ids = array_filter(explode(',', $this->reasons));

        if (empty($ids)) {
            return collect();
        }

        return Reasons::whereIn('id', $ids)->pluck('reason');
    }


    public function GetCategory($worker_id)
    {

        $application_category = MainWorkerForm::where('worker_id', $worker_id)->first();
        $application_category = $application_category->already_registered ?? '';

        if ($application_category == '') {
            return 0;
        } else {
            return 1;
        }

    }
    public function getSenderUserName()
    {
        return $this->belongsTo(User::class, 'sender_user_id', 'id');
    }


    public function getReceiver()
    {
        return $this->belongsTo(User::class, 'application_receiver_user_id', 'id');
    }

    public function getNewApproved()
    {
        return $this->hasOne(MainWorkerForm::class, 'ack_no', 'ack_no');
    }

    // public function getHro($officeId)
    // {
    //     $user = User::where('office_id', $officeId)->where('role_id', 2)->first();
    //     return $user;
    // }

    public function getHro($officeId)
{
    $user = User::where('office_id', $officeId)
                ->whereHas('roles', function ($q) {
                    $q->where('id', 2); // or ->where('name', 'HRO')
                })
                ->first();
    return $user;
}

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function senderRole()
    {
        return $this->belongsTo(Role::class, 'sender_role_id');
    }





}
