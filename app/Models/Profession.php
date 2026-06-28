<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    protected $table = "Masterdata.professions";

    protected $primaryKey = "profession_code";

    protected $fillable = [
        'profession_code',
        'profession_name'
    ];
    public function basicDetailsWorkers()
    {
        return $this->hasMany(MainWorkerBasicDetail::class, 'profession', 'profession_code');
    }
    public function certificateWorkers()
    {
        return $this->hasMany(MainworkerCetificate::class, 'profession', 'profession_code');
    }
}
