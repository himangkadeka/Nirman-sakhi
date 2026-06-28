<?php

namespace App\Rules;

use App\Models\Amount;
use App\Models\MainWorkerForm;
use App\Models\WorkerSubscription;
use Illuminate\Contracts\Validation\Rule;

class MatchAmount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $paymentType;
    protected $totalAmount;
    protected $mobileNo;
    public function __construct($paymentType, $totalAmount, $mobileNo)
    {
        $this->paymentType = $paymentType;
        $this->totalAmount = $totalAmount;
        $this->mobileNo = $mobileNo;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $amount = null;
        if (session()->has('worker')) {
            $record['workerData'] = session()->get('worker');
            $workerId = $record['workerData']->worker_id;
        } else {
            $workerId = session()->get('worker_id');
        }
        $record['phone'] = MainWorkerForm::where('worker_id', $workerId)->first()->phone_no;


        if ($this->paymentType == 03) {
            $amount = Amount::find(1)->amount;
        } elseif ($this->paymentType == 12) {
            $subscription_amount = WorkerSubscription::where('worker_id', $workerId)->where('payment_status', 0)->latest()->first();
            if ($subscription_amount) {
                $amount = $subscription_amount->total_amount;
            }
        }

        // Check if the value matches the retrieved amount
        return $value == $amount;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Amount is Invalid.';
    }
}
