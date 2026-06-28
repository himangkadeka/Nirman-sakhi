<form action="#" class="form-group" method="post"
        id="payment-verification-form" style="display:none">
        @csrf

        <input type="text" name="DEPARTMENT_ID" value="{{$department_id->DEPARTMENT_ID}}">
        <input type="hidden" name="OFFICE_CODE" value="{{$egrass_office_code}}">
        <input type="text" class="form-control uc-text-smooth" id="AMOUNT" value="{{$amount}}"
            name="AMOUNT" placeholder="" readonly>
        <input type="hidden" name="ACTION_CODE" value="GETCIN">
        <input type="hidden" name="SUB_SYSTEM" value="BOCW">

    </form>

    <form action="{{env('GRAS_PAYMENT_URL')}}/challan/models/frmgetgrn.php" method="POST" id="payment-verification-submit-form" style="display: none">
        <input type="text" id="enc_string_ver" name="PORTAL_ENCDATA">
        <input type="hidden" name="MERCHANT_ID" value="BOCW">
    </form>
