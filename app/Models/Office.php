<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $table = "Masterdata.offices";
    protected $primaryKey = 'office_id';
    protected $fillable = [
        'office_id',
        'district_code',
        'office_name',
        'egrass_office_code'
    ];


    public function districts()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }

    public function getCount($office_id)
    {
        $count = MainWorkerForm::where('office_id', $office_id)->count();
        return $count;
    }

    public function workers()
    {
        return $this->hasMany(MainWorkerForm::class, 'office_id', 'office_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'office_id', 'office_id');
    }

    public function userCount()
    {
        return $this->users()->count();
    }

    public function newRegistrationsCount($office_id)
    {
        return MainWorkerForm::where('already_registered', null)->where('office_id', $office_id)->count();
    }

    public function alreadyRegisteredCount($office_id)
    {
        return MainWorkerForm::where('already_registered', 1)->where('office_id', $office_id)->count();
    }

    public function pendingApplicationCount($office_id)
    {
        $count = MainWorkerForm::where('office_id', $office_id)->whereNotIn('status', ['F', 'D', 'G'])->count();
        return $count;
    }

    public function newApprovedApplicationCount($office_id)
    {
        $count = MainWorkerForm::where('office_id', $office_id)->where('status', 'F')
            ->where('already_registered', null)->count();
        return $count;
    }

    public function OnApprovedApplicationCount($office_id)
    {
        $count = MainWorkerForm::where('office_id', $office_id)->where('status', 'F')
            ->where('already_registered', 1)->count();
        return $count;
    }
    public function approvedApplicationCount($office_id)
    {
        $count = MainWorkerForm::where('office_id', $office_id)->where('status', 'F')->count();
        return $count;
    }

    public function rejectedApplicationCount($office_id)
    {
        $count = CancelledAppModal::where('office_id', $office_id)->where('status', 'D')->count();
        return $count;
    }

    public function revertedApplicationCount($office_id)
    {
        $count = RevertBack::where('office_id', $office_id)->where('status', 'G')->count();
        return $count;
    }

    public function applications()
    {
        return $this->hasMany(WorkerApplicationStatus::class, 'office_id', 'id');
    }

    public function applicationCount()
    {
        return $this->applications()->count();
    }

    public function notResubmittedCount($office_id){
       $count = RevertBack::where('office_id', $office_id)->where('resubmit_status', 0)->count();
        return $count;
    }
}
