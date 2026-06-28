<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'User.users';
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'role_id',
        'office_id',
        'district',
        'designation_id',
        'status',
        'password_change_first_attempt',
        'is_incharge'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }

    public function districts()
    {
        return $this->belongsTo(District::class, 'district', 'district_code');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function dscData()
    {
        return $this->belongsTo(DscRegistration::class, 'id', 'user_id');
    }

    public function getCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('office_id', $office_id)->where(function ($query) use ($user_id) {
                $query->whereNull('application_receiver_user_id')
                    ->orWhere('application_receiver_user_id', $user_id);
            })->count();
        } else {
            $count = MainWorkerForm::where('office_id', $office_id)->where('application_receiver_user_id', $user_id)->count();
        }
        return $count;
    }


    public function getReceivedApplicationsCount()
    {
        return WorkerApplicationStatus::where('application_receiver_user_id', $this->id)
            ->whereHas('mainWorker', function ($query) {
                $query->where('office_id', $this->office_id);
            })
            ->count();
    }



    public function newUserRegistrationsCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('already_registered', null)->where('office_id', $office_id)->where(function ($query) use ($user_id) {
                $query->whereNull('application_receiver_user_id')
                    ->orWhere('application_receiver_user_id', $user_id);
            })->count();
        } else {
            $count = MainWorkerForm::where('already_registered', null)->where('office_id', $office_id)->where('application_receiver_user_id', $user_id)->count();
        }

        return $count;
    }

    public function alreadyUserRegisteredCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('already_registered', 1)->where('office_id', $office_id)->where(function ($query) use ($user_id) {
                $query->whereNull('application_receiver_user_id')
                    ->orWhere('application_receiver_user_id', $user_id);
            })->count();
        } else {
            $count = MainWorkerForm::where('already_registered', 1)->where('office_id', $office_id)->where('application_receiver_user_id', $user_id)->count();
        }

        return $count;
    }

    // Pending Application Count
    public function pendingUserApplicationCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('office_id', $office_id)
                ->whereNotIn('status', ['F', 'D', 'G'])
                ->where(function ($query) use ($user_id) {
                    $query->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user_id);
                })->count();
        } else {
            $count = MainWorkerForm::where('office_id', $office_id)
                ->whereNotIn('status', ['F', 'D', 'G'])
                ->where('application_receiver_user_id', $user_id)
                ->count();
        }
        return $count;
    }

    // Approved Application Count
    public function approvedUserApplicationCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'F')
                ->where(function ($query) use ($user_id) {
                    $query->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user_id);
                })->count();
        } else {
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'F')
                ->where('application_receiver_user_id', $user_id)
                ->count();
        }
        return $count;
    }

    // Rejected Application Count
    public function rejectedUserApplicationCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'D')
                ->where(function ($query) use ($user_id) {
                    $query->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user_id);
                })->count();
        } else {
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'D')
                ->where('application_receiver_user_id', $user_id)
                ->count();
        }
        return $count;
    }

    public function newApprovedUserApplicationCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'F')
                ->whereNull('already_registered')
                ->where(function ($query) use ($user_id) {
                    $query->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user_id);
                })->count();
        } else {
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'F')
                ->whereNull('already_registered')
                ->where('application_receiver_user_id', $user_id)
                ->count();
        }

        return $count;
    }

    // On Approved (Already Registered Worker) Application Count
    public function onApprovedUserApplicationCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'F')
                ->where('already_registered', 1)
                ->where(function ($query) use ($user_id) {
                    $query->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user_id);
                })->count();
        } else {
            $count = MainWorkerForm::where('office_id', $office_id)
                ->where('status', 'F')
                ->where('already_registered', 1)
                ->where('application_receiver_user_id', $user_id)
                ->count();
        }

        return $count;
    }

    // Reverted Application Count
    public function revertedUserApplicationCount($office_id, $user_id, $role_id)
    {
        if ($role_id == 2) {
            $user_id = !empty($user_id) ? $user_id : null;
            $count = RevertBack::where('office_id', $office_id)
                ->where('status', 'G')
                ->where(function ($query) use ($user_id) {
                    $query->whereNull('user_id')
                        ->orWhere('user_id', $user_id);
                })->count();
        } else {
            $count = RevertBack::where('office_id', $office_id)
                ->where('status', 'G')
                ->where('user_id', $user_id)
                ->count();
        }

        return $count;
    }
}
