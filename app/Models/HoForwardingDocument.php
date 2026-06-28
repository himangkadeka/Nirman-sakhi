<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoForwardingDocument extends Model
{
    use HasFactory;

    protected $table = "Benefit.ho_forwarding_documents";

    protected $fillable = [
        'office_id',
        'user_id',
        'meeting_minutes_path',
        'attendance_sheet_path',
        'accepted_list_path',
        'rejected_list_path',
        'submission_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
