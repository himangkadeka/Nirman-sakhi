<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District; // Correct namespace

class IndexNotification extends Model
{
    use HasFactory;

    protected $table = 'Content.index_notifications';
    protected $primaryKey = 'id';

    // Define fillable fields for mass assignment
    protected $fillable = ['pdf_path', 'caption', 'year', 'benefit_id', 'category', 'district_code','status'];

    // Enable timestamps
    public $timestamps = true;

    public function districts()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }


    public function benefit()
    {
        return $this->belongsTo(TypeOfBenefit::class, 'benefit_id');
    }


     // Relationship with the District model (Singular)
     public function district()
     {
         return $this->belongsTo(District::class, 'district_code', 'district_code');
     }


}
