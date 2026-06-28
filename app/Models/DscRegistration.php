<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DscRegistration extends Model
{
    use HasFactory;

    protected $table = "User.dsc_registrations";

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'seriel_number',
        'valid_from',
        'valid_to',
        'certificate',
        'status',
        'pan'
    ];
}
