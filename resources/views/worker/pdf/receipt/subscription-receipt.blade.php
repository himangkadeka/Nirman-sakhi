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
            <h2><span>Subscription Payment Receipt</span></h2>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: rgb(205, 205, 205);">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;"><span>Acknowledgement Number:</span> <span style="color: red">{{$subscription->ack_no}}</span></td>
                    <td style="text-align: right;"><span>Date :</span><span style="color: red"> {{ \Carbon\Carbon::parse($subscription->created_at)->format('d-m-Y') }}</span></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <p style="text-align: left; padding-left: 10px; padding-right: 20px"><span style="padding-left: 70px">Dear {{ $getVaultData['name'] }} </span>, you have successfully paid your subscription to the ABOCWWB till
                <span>{{ \Carbon\Carbon::parse($subscription->to_period)->format('d-m-Y')  }}</span> on {{\Carbon\Carbon::parse($subscription->updated_at)->format('d-m-Y') }}. </p>
        </td>
    </tr>

    <tr>
        <td style="text-align: left; padding-left: 10px; padding-right: 20px" colspan="2">
            <strong>The following fee payment has been received for this application. </strong>
            <p>
                Amount Paid: <span>{{ $subscription->total_amount }}.00</span><br>
                Membership subscription fee: <span>{{ $subscription->total_amount }}.00 </span><br>
                {{--Penalty Amount Paid : <span>{{ $subscription->total_amount - ($subscription->penalty_months * 20) }}</span><br>--}}
                Payment Date: <span>{{ \Carbon\Carbon::parse($subscription->updated_at)->format('d-m-Y') }}</span><br>
                Payment Mode: <span>Online</span><br>
                ID card: <span>{{ $subscription->id_card_no }}</span><br>
                Subscription validity (Till date): <span>{{ $subscription->to_period }}</span>
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
