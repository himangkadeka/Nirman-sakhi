<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerIDCardHistory extends Model
{
    protected $table = 'Worker.worker_id_cards_history';

    protected $fillable = [
        'worker_id',
        'id_card_status',
        'signature_status',
        'certificate',
        'certificate_upload_date',
        'archived_at'
    ];

    public $timestamps = false;
}
