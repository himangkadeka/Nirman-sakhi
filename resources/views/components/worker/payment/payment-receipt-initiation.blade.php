<form action="{{env('GRAS_PAYMENT_URL')}}/challan/views/frmEpayEchallanPrintMerge.php" class="form-group" method="post" id="payment-receipt-form" style="display:none">
    @csrf

    <input type="hidden" name="DEPARTMENT_ID" value="{{ $department_id->DEPARTMENT_ID }}">
    <input type="hidden" name="GRN" value="{{$department_id->GRN}}">
    <input type="hidden" name="OFFICE_CODE" value="{{$egrass_office_code}}">
    <input type="hidden" id="AMOUNT" value="{{ $department_id->AMOUNT }}" name="AMOUNT">
    <input type="hidden" name="VIEWCHALLAN" value="Y">
    <input type="hidden" name="hcin_no" value="{{$department_id->GRN}}">
    <input type="hidden" name="OUTSIDE" value="OUTSIDE">

</form>

<form action="{{env('GRAS_PAYMENT_URL')}}/challan/views/frmEpayEchallanPrintMerge.php" method="POST"
    id="payment-receipt-submit-form" style="display: none">
    <input type="text" id="enc_string_rec" name="PORTAL_ENCDATA">
    <input type="hidden" name="GRN" value="{{$department_id->GRN}}">
</form>
