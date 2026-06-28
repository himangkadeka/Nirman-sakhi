<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkbookUpload extends Model
{
    use HasFactory;
    protected $table = "Worker.workbook_uploads";

    protected $primaryKey = "id";

    protected $fillable =[
        'worker_id',
        'workbook',

    ];
}
