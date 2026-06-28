<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfBenefit extends Model
{
    use HasFactory;

    protected $table = 'Masterdata.type_of_benefits';
    protected $fillable = ['benefit_name']; // Correct column name


    public function notifications()
    {
        return $this->hasMany(IndexNotification::class, 'id');
    }
}
