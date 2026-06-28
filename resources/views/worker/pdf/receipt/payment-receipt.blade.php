<style>

    .font-pdf{
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
            <h2><span>Payment Acknowledgement Receipt</span></h2>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: rgb(205, 205, 205);">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;"><span>Acknowledgement No :</span> <span style="color: red">{{$mwf->ack_no}}</span></td>
                    <td style="text-align: right;"><span>Date :</span><span style="color: red"> {{\Carbon\Carbon::parse($mfb->created_at)->format('d-m-Y')}}</span></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <p style="text-align: justify; padding-left: 10px; padding-right: 20px"><span style="padding-left: 70px">Dear {{ $getVaultData->name }} </span>, Your application No. {{$worker->application_no}} for Registration with ABOCWWB has been submitted successfully on {{$mfb->created_at}}. Your application acknowledgement no. is {{$mwf->ack_no}}. </p>
        </td>
    </tr>

    <tr>
        <td style="text-align: left; padding-left: 10px; padding-right: 20px" colspan="2">
            <strong>The following fee payment has been received for this application. </strong>
            <p>
                Membership subscription fee: <span>Rs. 25.00</span><br>
                Payment Date: <span>{{ now()->format('d-m-Y') }}</span><br>
                Payment Mode: <span>Online</span><br>
                Registration ID: <span>{{ $mwf->ack_no }}</span>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-left: 10px; padding-right:20px">
            <p style="text-align: left; padding-left:5px">
                Thank you,<br>
                ABOCWWB
            </p>
        </td>
    </tr>
</table>
