<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UserTransfer extends Model
{
    use  HasFactory;

    protected $table = 'User.user_transfers';
    protected $fillable = [
        'user_id',
        'username',
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'role',
        'is_incharged',
        'designation',
        'is_retired',
        'retired_at',
        'transfer_from_district',
        'transfer_to_district',
        'transfer_from_office',
        'transfer_to_office',
        'tenure_end_date',
        'transfer_document'


    ];
    public function designations()
    {
        return $this->belongsTo(Designation::class, 'designation', 'id');
    }

    public function officeFrom()
    {
        return $this->belongsTo(Office::class, 'transfer_from_office', 'office_id');
    }

    public function officeTo()
    {
        return $this->belongsTo(Office::class, 'transfer_to_office', 'office_id');
    }

    public function districtsFrom()
    {
        return $this->belongsTo(District::class, 'transfer_from_district', 'district_code');
    }

    public function districtsTo()
    {
        return $this->belongsTo(District::class, 'transfer_to_district', 'district_code');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }
}
