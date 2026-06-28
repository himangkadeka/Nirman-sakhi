<style>
    .font-pdf {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<table class="font-pdf" style="width: 100%; height: 60%; text-align: center; border-collapse: collapse; border: 1px solid #000;">
@php
    use Carbon\Carbon;
@endphp

<!-- Emblem -->
    <tr>
        <td colspan="2">
            <img src="{{ $emblem }}" alt="National Emblem of India" title="Emblem of India" style="margin-top: 20px;">
        </td>
    </tr>

    <!-- Header -->
    <tr>
        <td colspan="2">
            <h2>Application Acknowledgement Receipt</h2>
        </td>
    </tr>

    <!-- Acknowledgement & Date -->
    <tr>
        <td colspan="2" style="background-color: rgb(205, 205, 205);">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;">
                        <strong>Acknowledgement No:</strong> <span style="color: red;">{{ $mwf->ack_no }}</span>
                    </td>
                    <td style="text-align: right;">
                        <strong>Date:</strong> <span style="color: red;">{{ Carbon::parse($mfb->created_at)->format('d-m-Y') }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Greeting & Submission Confirmation -->
    <tr>
        <td colspan="2">
            <p style="text-align: justify; padding: 0 20px 0 10px;">
                <span style="padding-left: 70px;">
                    Dear <strong>{{ $getVaultData['name'] ?? 'NA' }}</strong>,
                </span>
                <br>
                Your application for Registration with ABOCWWB has been
                @if($revert_back > 0) re-submitted @else submitted @endif
                successfully on <strong>{{ Carbon::parse($mfb->created_at)->format('d-m-Y') }}</strong>.<br>
                Your application acknowledgement no. is <strong>{{ $mwf->ack_no }}</strong>.
            </p>
        </td>
    </tr>

    <!-- Tracking and Communication Info -->
    <tr>
        <td colspan="2">
            <p style="text-align: justify; padding: 0 20px 0 10px;">
                <span style="padding-left: 70px;">
                    Please use this acknowledgement no.
                </span>
                <strong>{{ $mwf->ack_no }}</strong> for tracking the status of your application through
                <strong>{{ env('APP_URL') }}</strong> and for any future communication related to this application.
                <br>
                If the application is accepted by ABOCWWB, the service shall be provided within the stipulated time.
                <br>
                You can write to us at <strong>abocww.board@assam.gov.in</strong> for any feedback or grievances.
            </p>
        </td>
    </tr>

    <!-- Additional Details -->
    <tr>
        <td colspan="2" style="text-align: left; padding: 0 20px 0 10px;">
            <strong>The following are the details for this application:</strong>
            <p>
                Old BOCW Number:
                <strong>
                    @if($bocwCard)
                        {{ $bocwCard->existing_card }}
                    @else
                        {{ $worker->worker_id }}
                    @endif
                </strong>
                <br>
                Onboarding Date: <strong>{{ Carbon::parse($worker->created_at)->format('d-m-Y') }}</strong>
            </p>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td colspan="2" style="text-align: left; padding: 0 20px 0 10px;">
            <p>
                Thank you,<br>
                ABOCWWB
            </p>
        </td>
    </tr>
</table>
