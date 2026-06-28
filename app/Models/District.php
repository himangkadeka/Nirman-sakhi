<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = "Masterdata.districts";
    protected $primaryKey = "district_code";
    protected $fillable =[
        'district_code',
        'state_code',
        'district_name',
        'status'
    ];


    public function state(){
        return $this->belongsTo(State::class,'state_code','state_code');
    }

    public function pfcs()
    {
        return $this->hasMany(PfcList::class, 'district_code', 'district_code');
    }
    public function getCount($district_code){
        $count = MainWorkerForm::where('district',$district_code)->count();
        return $count;
    }
    public function getCountNew($district_code){
        $count = MainWorkerForm::where('district',$district_code)->where('already_registered',null)->count();
        return $count;
    }
    public function getCountOnboarding($district_code){
        $count = MainWorkerForm::where('district',$district_code)->where('already_registered',1)->count();
        return $count;
    }

    public function getCountApp($district_code){
        $count = MainWorkerForm::where('district',$district_code)->where('status','F')->count();
        return $count;
    }
    public function getCountPending($district_code)
    {

        $countMain = MainWorkerForm::where('district', $district_code)
            ->where('status', '!=', 'F')
            ->count();

        $countRevert = RevertBack::where('district', $district_code)
            ->where('resubmit_status', '!=', '1')
            ->where('ack_no', 'ILIKE', '%/reg/%')
            ->count();

        $totalCount = $countMain + $countRevert;

        return $totalCount;
    }

    public function getCountReject($district_code){
        $count = CancelledAppModal::where('district',$district_code)->count();
        return $count;
    }
    public function getCountReverted($district_code){
        $count = RevertBack::where('district',$district_code)
            ->where('ack_no', 'ILIKE', '%/reg/%')
            ->count();
        return $count;
    }

    public function getResubmittedCount($district_code){
        $countRevert = RevertBack::where('district',$district_code)
            ->where('ack_no', 'ILIKE', '%/reg/%')
            ->count();

        $countResubmit = RevertBack::where('district', $district_code)
            ->where('resubmit_status', '!=', '1')
            ->where('ack_no', 'ILIKE', '%/reg/%')
            ->count();
        return $totalCount = $countRevert - $countResubmit;
    }
   public function getRevertNotSubmitted($district_code)
   {
     $count =  RevertBack::where('district', $district_code)
           ->where('resubmit_status', 0)
           ->where('ack_no', 'ILIKE', '%/reg/%')
            ->count();
     return $count;

   }


}
