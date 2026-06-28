<style>
    .font-pdf{
        font-family: Arial, Helvetica, sans-serif;
    }
    .receipt-table{
        width: 100%;
        text-align: center;
        border-collapse: collapse;
        border: 1px solid #000;
    }
    .grey-bg{
        background-color: rgb(205,205,205);
    }
    .p-justify{
        text-align: justify;
        padding: 0 20px;
    }
</style>

@if($isRenew)

    <table class="font-pdf receipt-table" style="height:50%;">
        <tbody>

        <tr>
            <td colspan="2">
                <img src="{{ $emblem }}" alt="National Emblem of India" style="margin-top:20px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <h2>Renewal Application Acknowledgement Receipt</h2>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="grey-bg">
                <table style="width:100%;">
                    <tr>
                        <td style="text-align:left; padding-left:10px;">
                            Acknowledgement No :
                            <span style="color:red;">{{ $mwf->ack_no }}</span>
                        </td>
                        <td style="text-align:right; padding-right:10px;">
                            Date :
                            <span style="color:red;">{{ Carbon\Carbon::parse($worker->created_at)->format('d-m-Y') }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p class="p-justify">
                <span style="padding-left:70px;">
                    Dear <strong>{{ $getVaultData['name'] ?? 'NA' }}</strong>,
                </span><br>
                    Your application for Renewal with ABOCWWB has been
                    @if($revert_back > 0) Re-submitted @else submitted @endif
                    successfully on
                    <strong>{{ Carbon\Carbon::parse($worker->created_at)->format('d-m-Y') }}</strong>.<br>
                    Your application acknowledgement no. is
                    <strong>{{ $worker->ack_no }}</strong>.
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p class="p-justify">
                    <span style="padding-left:70px;">Please use this acknowledgement no.</span>
                    <strong>{{ $worker->ack_no }}</strong> for tracking your application status through
                    <strong>{{ env('APP_URL') }}</strong>. <br>
                    If the application is accepted by ABOCWWB, the service will be provided within the stipulated time. <br>
                    For any feedback, write to <strong>abocww.board@assam.gov.in</strong>.
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p style="text-align:left; padding-left:25px;">
                    Thank you,<br>
                    ABOCWWB
                </p>
            </td>
        </tr>

        </tbody>
    </table>

@else

    <table class="font-pdf receipt-table" style="height:60%;">
        <tr>
            <td colspan="2">
                <img src="{{ $emblem }}" alt="National Emblem of India" style="margin-top:20px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <h2>Application Acknowledgement Receipt</h2>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="grey-bg">
                <table style="width:100%;">
                    <tr>
                        <td style="text-align:left;">
                            Acknowledgement No :
                            <span style="color:red;">{{ $mwf->ack_no }}</span>
                        </td>
                        <td style="text-align:right;">
                            Date :
                            <span style="color:red;">{{ Carbon\Carbon::parse($mfb->created_at)->format('d-m-Y') }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p class="p-justify" style="padding-left:10px;">
                <span style="padding-left:70px;">
                    Dear <strong>{{ $getVaultData['name'] ?? 'NA' }}</strong>,
                </span><br>
                    Your application for Registration with ABOCWWB has been
                    @if($revert_back > 0) Re-submitted @else submitted @endif
                    successfully on
                    <strong>{{ Carbon\Carbon::parse($mfb->created_at)->format('d-m-Y') }}</strong>.<br>
                    Your application acknowledgement no. is
                    <strong>{{ $mwf->ack_no }}</strong>.
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p class="p-justify" style="padding-left:10px;">
                    <span style="padding-left:70px;">Please use this acknowledgement no.</span>
                    <strong>{{ $mwf->ack_no }}</strong>
                    for tracking the status of your application through
                    <strong>{{ env('APP_URL') }}</strong>. <br>
                    If the application is accepted by ABOCWWB, the service shall be provided within the stipulated time. <br>
                    You can write to us at <strong>abocww.board@assam.gov.in</strong> for any feedback.
                </p>
            </td>
        </tr>

        @if($worker->already_registered === null)
            <tr>
                <td colspan="2" style="text-align:left; padding:10px;">
                    <strong>The following fee payment has been received:</strong>
                    <p>
                        Registration fee: {{ $payment_date->AMOUNT ?? '0.00' }}<br>
                        Payment Date:
                        {{ isset($payment_date) ? Carbon\Carbon::parse($payment_date->created_at)->format('d-m-Y') : now()->format('d-m-Y') }}<br>
                        Transaction Id: {{ $payment_date->DEPARTMENT_ID ?? 'N/A' }}
                    </p>
                </td>
            </tr>
        @endif

        @if($worker->already_registered == 1)
            <tr>
                <td colspan="2" style="text-align:left; padding:10px;">
                    <strong>Application Details:</strong>
                    <p>
                        Old BOCW Number: <strong>{{ $worker->worker_id }}</strong><br>
                        Onboarding Date: <strong>{{ Carbon\Carbon::parse($worker->created_at)->format('d-m-Y') }}</strong>
                    </p>
                </td>
            </tr>
        @endif

        <tr>
            <td colspan="2">
                <p style="text-align:left; padding-left:25px;">
                    Thank you,<br>
                    ABOCWWB
                </p>
            </td>
        </tr>

    </table>

@endif
