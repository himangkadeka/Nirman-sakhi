<table style="width: 100%; text-align: center; border-collapse: collapse; border: 1px solid #000;">

    <tr>
        <td colspan="2">
            <img src="assets/template/images/emblem-dark.png" alt="National Emblem of India" title="emblem of india logo" style="margin-top: 20px">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h2><span>Application Acknowledgement Receipt</span></h2>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: rgb(205, 205, 205);">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;"><span>Acknowledgement No. :</span><span style="color: red"> XXXXXXXXX</span></td>
                    <td style="text-align: right;"><span>Date :</span><span style="color: red"> {{ now() }}</span></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <p style="text-align: left; padding-left: 20px; padding-right: 20px">Dear <span>{{$mfb->first_name}} {{$mfb->last_name}}, <br></span>
            Your application No. <span style="color: red">{{$worker->worker_id}}</span> for <span style="font-weight:bold">Registration with ABOCWWB</span> has been submitted successfully on <span style="color: red">{{ now()->format('d-m-Y') }}</span> at <span style="color: red">XX:XX am/pm</span>. Your application acknowledgement no. is <span style="color:red">{{$worker->worker_id}}</span>.
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p style="text-align: left; padding-left: 20px; padding-right: 20px; margin-top: -8px">
                Please use this acknowledgement no. <span style="color:red">{{$worker->worker_id}}</span> for tracking the status of your application
                through <span style="color:red">https://abocwwb.assam.gov.in</span> and for any future communication related to this application. If the
                application is accepted by ABOCWWB, the service shall be provided within the stipulated time. You can
                write to us at <span style="color:red">XXXXXX</span> for any feedback or grievances.
            </p>
        </td>
    </tr>
    <tr>
        <td style="text-align: left; padding-left: 20px; padding-right: 20px" colspan="2">
            <strong>The following fee payment has been received for this application. </strong>
            <p style="padding-left: 40px; padding-right: 40px">
                Registration fee : <span style="color:red">Paid</span><br>
                Payment Date : <span style="color:red">{{ now()->format('d-m-Y') }}</span><br>
                Payment Mode : <span style="color:red">Online</span><br>
                Printout Charges (if applicable) : <span style="color:red">INR XXXX</span>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: left; padding-left: 20px; padding-right: 20px">
            <p style="text-align: left">
                Thank you,<br>
                ABOCWWB
            </p>
        </td>
    </tr>
</table>
