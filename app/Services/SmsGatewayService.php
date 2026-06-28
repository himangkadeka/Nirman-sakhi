<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsGatewayService
{

    public function sendSms($url)
    {
        $response = @file_get_contents($url);

        if ($response === false) {
            return false;
        }
        return $response;
    }

    // 1. APPLICATION SUBMISSION SMS
    public function applicationSubmissionSMS($mobile, $application_no, $application_fee)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170746375754510&msg=Your%20Application%20No.%20" . $application_no . "%20for%20the%20Registration%20of%20BOCW%20worker%20with%20fees%20of%20Rs.%20" . $application_fee . "%20is%20successfully%20submitted.";
        $this->sendSms($url);
    }

    // 2. APPLICATION APPROVED SMS

    public function appliacationApprovalSMS($mobile, $application_no, $downloadId_url)
    {
        // $url = "https://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=".$mobile."&te_id=1107170746425364379&msg=Your%20Application%20No.%20".$application_no."%20is%20APPROVED.Kindly%20download%20your%20ID%20Card%20from%20ABOCWWB%20and%20pay%20the%20monthly%20subscription%20fee.";
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=".$mobile."&te_id=1107170746425364379&msg=Your%20Application%20No.%20".$application_no."%20is%20APPROVED.Kindly%20download%20your%20BOCW%20Card%20from%20ABOCWWB%20portal%20and%20pay%20the%20monthly%20subscription%20fee.";
        $this->sendSms($url);
        // $message = "Your Application No. " . $application_no . " is APPROVED. Kindly download your BOCW Card from " . $downloadId_url . " and pay the monthly subscription fee.";
        // $encodedMessage = urlencode($message);

//         $url = "https://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170746425364379&msg=" . $encodedMessage;
// return $url;
        // $this->sendSms($url);
    }

    // 3. SUBSCRIPTION FEE RECEIVED SMS

    public function subscriptionFeeReceivedSMS($mobile, $subscription_fee, $subscription_from_period, $subscription_to_period, $bocw_card_no, $next_due_date)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170746465398797&msg=The%20Subscription%20fees%20of%20Rs.%20" . $subscription_fee . "%20is%20received%20for%20the%20period%20" . $subscription_from_period . "-" . $subscription_to_period . "%20against%20BOCW%20Card%20No.%20" . $bocw_card_no . ".Your%20next%20due%20is%20" . $next_due_date . ".";
        $this->sendSms($url);
    }

    // 4. RENEWAL APPLICATION SUBMIT SMS

    public function renewalApplicationSubmitSMS($mobile, $application_no, $bocw_card_no)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170746501785077&msg=Your%20Application%20No.%20" . $application_no . "%20for%20the%20renewal%20of%20BOCW%20Card%20No.%20" . $bocw_card_no . "%20is%20successfully%20SUBMITTED.";
        $this->sendSms($url);
    }

    // 5. RENEWAL APPLICATION APPROVED SMS

    public function renewalApplicationApprovedSMS($mobile, $application_no, $bocw_card_no)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170746534876135&msg=Your%20Application%20No.%20" . $application_no . "%20for%20the%20renewal%20of%20BOCW%20Card%20No.%20" . $bocw_card_no . "%20is%20APPROVED.Kindly%20download%20it%20from%20abocwwb.assam.gov.in.";
        $this->sendSms($url);
    }

    // 6. APPLICATION REVERTED SMS

    public function applicationRevertedSMS($mobile, $application_no, $remark)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170746564854055&msg=Your%20Application%20No.%20" . $application_no . "%20for%20Registration%20of%20BOCW%20worker%20is%20REVERTED%20to%20the%20Applicant.Remarks%3A%20" . $remark . "%20Required.";

        $this->sendSms($url);

    }

    // 7. APPLICATION REJECTED SMS

    public function applicationRejectedSMS($mobile, $application_no, $remark)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170746600628817&msg=Your%20Application%20No.%20" . $application_no . "%20for%20Registration%20of%20BOCW%20worker%20is%20REJECTED.Remarks%3A%20" . $remark . ".";
        $this->sendSms($url);
    }

    // 8. RENEWAL APPLICATION REVERTED SMS

    public function renewalApplicationRevertedSMS($mobile, $application_no, $remark)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170747169906449&msg=Your%20Application%20No.%20" . $application_no . "%20for%20renewal%20of%20BOCW%20Card%20No.%20CRD989899D%20is%20REVERTED%20to%20the%20Applicant.Remarks%3A%20" . $remark . ".";
        $this->sendSms($url);
    }

    // 9. RENEWAL APPLICATION REJECTED SMS

    public function renewalApplicationRejectedSMS($mobile, $application_no, $remark)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170747192892437&msg=Your%20Application%20No.%20" . $application_no . "%20for%20Renewal%20of%20BOCW%20Card%20No.%20BRD78888%20is%20REJECTED.Remarks%3A%20" . $remark . ".";
        $this->sendSms($url);
    }

    // 10. RENEWAL DUE ALERT SMS

    public function renewalDueAlertSMS($mobile, $bocw_card_no, $renewal_due_date, $renewal_url)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170747263500281&msg=Your%20BOCW%20Card%20No.%20" . $bocw_card_no . "%20is%20due%20for%20Renewal%20on%20" . $renewal_due_date . ".Kindly%20visit%20" . $renewal_url . "%20for%20Renewal.";
        $this->sendSms($url);
    }

    // 11. INACTIVE ALERT SMS

    public function inactiveAlertSMS($mobile, $bocw_card_no, $inactive_date, $renewal_url)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170747292901062&msg=Your%20BOCW%20Card%20No.%20" . $bocw_card_no . "%20is%20due%20to%20become%20INACTIVE%20on%20" . $inactive_date . ".Kindly%20visit%20" . $renewal_url . "%20for%20renewal%20at%20the%20earliest.";
        $this->sendSms($url);
    }

    // 12. PARMANANT INACTIVE ALERT SMS

    public function parmanentlyInactiveAlertSMS($mobile, $bocw_card_no)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170747317950308&msg=Your%20BOCW%20Card%20No.%20" . $bocw_card_no . "%20has%20parmanently%20become%20INACTIVE.%20Kindly%20Register%20again%20for%20availing%20the%20welfare%20benefits.";
        $this->sendSms($url);
    }


    // LOGIN OTP SMS
    public function loginOtpSMS($mobile, $otp)
    {
        $url = "http://sms.amtronindia.in/form_/send_api_master_get.php?agency=AMTRON&password=lc@123&district=ALL&app_id=Labour_Commiss&sender_id=ASBOCW&unicode=false&to=" . $mobile . "&te_id=1107170747345956254&msg=OTP%20for%20Login%20into%20Assam%20BOCW%20Portal%20is%20" . $otp . "%20%28valid%20for%2010%20minutes%29.%20Kindly%20do%20not%20share%20with%20anyone";
        $this->sendSms($url);
    }
}
