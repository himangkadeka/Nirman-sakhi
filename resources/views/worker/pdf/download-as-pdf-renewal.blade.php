<style>
    .font-pdf {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<table class="font-pdf" style="width: 100%; height:50%; text-align: center; border-collapse: collapse; border: 1px solid #000;">
    <tbody>
    <tr>
        <td colspan="2" style="text-align: center;">
            <img src="{{ $emblem }}" alt="National Emblem of India" title="emblem of india logo" style="margin-top: 20px;">
        </td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: center;">
            <h2><span>Renewal Application Acknowledgement Receipt</span></h2>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="background-color: rgb(205, 205, 205);">
            @php use Carbon\Carbon; @endphp
            <table style="width: 100%;">
                <tbody>
                <tr>
                    <td style="text-align: left; padding-left: 10px;">
                        <span>Acknowledgement No :</span>
                        <span style="color: red;">{{ $mwf->ack_no }}</span>
                    </td>
                    <td style="text-align: right; padding-right: 10px;">
                        <span>Date :</span>
                        <span style="color: red;">{{ Carbon::parse($worker->created_at)->format('d-m-Y') }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <p style="text-align: justify; padding-left: 20px; padding-right: 20px;">
 <span style="padding-left: 70px;">
 Dear <span style="font-weight: bold;">{{ $getVaultData['name'] ?? 'NA' }}</span>,
 </span><br>
                Your application for Renewal with ABOCWWB has been
                @if($revert_back > 0) Re-submitted @else submitted @endif
                successfully on <span style="font-weight: bold;">{{ Carbon::parse($worker->created_at)->format('d-m-Y') }}</span>.<br>
                Your application acknowledgement no. is <span style="font-weight: bold;">{{ $worker->ack_no }}</span>.
            </p>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <p style="text-align: justify; padding-left: 20px; padding-right: 20px;">
                <span style="padding-left: 70px;">Please use this acknowledgement no.</span>
                <span style="font-weight: bold;">{{ $worker->ack_no }}</span>
                for tracking the status of your application through
                <span style="font-weight: bold;">{{ env('APP_URL') }}</span>
                and for any future communication related to this application. <br>
                If the application is accepted by ABOCWWB, the service shall be provided within the stipulated time. <br>
                You can write to us at <span style="font-weight: bold;">abocww.board@assam.gov.in</span> for any feedback.
            </p>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="padding-left: 20px; padding-right: 20px;">
            <p style="text-align: left; padding-left: 5px;">
                Thank you,<br>
                ABOCWWB
            </p>
        </td>
    </tr>
    </tbody>
</table>