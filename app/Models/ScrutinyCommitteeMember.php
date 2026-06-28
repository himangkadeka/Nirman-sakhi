<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScrutinyCommitteeMember extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "Benefit.scrutiny_committee_members";
    protected $fillable = ['office_id', 'name', 'designation','department', 'email', 'phone'];
}
