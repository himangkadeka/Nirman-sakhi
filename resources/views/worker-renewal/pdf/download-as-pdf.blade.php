<style>
    .font-pdf {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<table class="font-pdf" style="width: 100%; height:60%; text-align: center; border-collapse: collapse; border: 1px solid #000;">
    <tr>
        <td colspan="2">
            <img src="{{ $emblem }}" alt="National Emblem of India" title="emblem of india logo" style="margin-top: 20px">
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <h2><span>Application Acknowledgement Receipt</span></h2>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="background-color: rgb(205, 205, 205);">
            @php use Carbon\Carbon; @endphp
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;">
                        <span>Acknowledgement No :</span>
                        <span style="color: red">{{ $mwf->ack_no }}</span>
                    </td>
                    <td style="text-align: right;">
                        <span>Date :</span>
                        <span style="color: red">{{ Carbon::parse($mfb->created_at)->format('d-m-Y') }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <p style="text-align: justify; padding-left: 10px; padding-right: 20px">
                <span style="padding-left: 70px">
                    Dear <span style="font-weight: bold">{{ $getVaultData['name'] ?? 'NA' }}</span>,
                </span><br>
                Your application for Renewal with ABOCWWB has been
                @if($revert_back > 0) Re-submitted @else submitted @endif
                successfully on <span style="font-weight: bold">{{ Carbon::parse($mfb->created_at)->format('d-m-Y') }}</span>.<br>
                Your application acknowledgement no. is <span style="font-weight: bold">{{ $mwf->ack_no }}</span>.
            </p>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <p style="text-align: justify; padding-left: 10px; padding-right: 20px">
                <span style="padding-left: 70px">Please use this acknowledgement no.</span>
                <span style="font-weight: bold;">{{ $mwf->ack_no }}</span>
                for tracking the status of your application through
                <span style="font-weight: bold;">{{ env('APP_URL') }}</span>
                and for any future communication related to this application. <br>
                If the application is accepted by ABOCWWB, the service shall be provided within the stipulated time. <br>
                You can write to us at <span style="font-weight: bold;">abocww.board@assam.gov.in</span> for any feedback.
            </p>
        </td>
    </tr>

    @if($worker->already_registered == null)
        <tr>
            <td style="text-align: left; padding-left: 10px; padding-right: 20px" colspan="2">
                <strong>The following fee payment has been received for this application.</strong>
                <p>
                    Registration fee: <span>{{ $payment_date->AMOUNT ?? '0.00' }}</span><br>
                    Payment Date:
                    <span>
                        {{ isset($payment_date) ? Carbon::parse($payment_date->created_at ?? now())->format('d-m-Y') : now()->format('d-m-Y') }}
                    </span><br>
                    Transaction Id: <span>{{ $payment_date->department_id ?? 'N/A' }}</span><br>
                </p>
            </td>
        </tr>
    @endif

    @if($worker->already_registered == '1')
        <tr>
            <td style="text-align: left; padding-left: 10px; padding-right: 20px" colspan="2">
                <strong>The following are the details for this application:</strong>
                <p>
                    Old BOCW Number: <span style="font-weight: bold">{{ $worker->worker_id }}</span><br>
                    Onboarding Date: <span style="font-weight: bold">{{ Carbon::parse($worker->created_at)->format('d-m-Y') }}</span><br>
                </p>
            </td>
        </tr>
    @endif

    <tr>
        <td colspan="2" style="padding-left: 10px; padding-right: 20px">
            <p style="text-align: left; padding-left: 5px">
                Thank you,<br>
                ABOCWWB
            </p>
        </td>
    </tr>
</table>
