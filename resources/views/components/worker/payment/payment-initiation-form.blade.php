{{-- @if ($department_id->STATUS == 'O') --}}
    <form action="#" class="form-group" method="post"
        id="payment-form" style="display:none">
        @csrf
        <input type="text" class="form-control uc-text-smooth" id="PARTY_NAME" value="{{ $getVaultData['name'] }}"
            name="PARTY_NAME" readonly>
        <input type="text" class="form-control uc-text-smooth" id="lastname" value="2024-2025" name="REC_FIN_YEAR"
            placeholder="" readonly>
        {{-- <input type="text" class="form-control uc-text-smooth" id="AMOUNT1" value="{{ $amount }}"
            name="AMOUNT1" placeholder="" readonly> --}}
        <input type="text" class="form-control" name="AC1_AMOUNT" value="{{ $amount }}" readonly>
        <input type="text" class="form-control" name="TOTAL_NON_TREASURY_AMOUNT" value="{{ $amount }}"
            readonly>
        <input type="text" class="form-control" name="MOBILE_NO" value="{{ $phone }}">
        <input type="text" class="form-control" id="REMARKS" name="REMARKS" value="">

        <input type="hidden" name="DEPT_CODE" value="{{env("DEPT_CODE")}}">
        <input type="hidden" name="PAYMENT_TYPE" value="">
        <input type="hidden" name="TREASURY_CODE" value="">
        <input type="hidden" name="OFFICE_CODE" value="{{$egrass_office_code}}">
        <input type="hidden" name="PERIOD" value="O">
        <input type="hidden" name="FROM_DATE" value="01/04/2024">
        <input type="hidden" name="TO_DATE" value="31/03/2099">
        <input type="hidden" name="MAJOR_HEAD" value="">
        <input type="hidden" name="HOA1" value="">
        <input type="hiddem" name="AMOUNT1" value="">
        <input type="hidden" name="CHALLAN_AMOUNT" value="0">
        <input type="hidden" name="MULTITRANSFER" value="Y">
        <input type="hidden" name="NON_TREASURY_PAYMENT_TYPE" value="{{env('PAYMENT_TYPE_CODE')}}">
        <input type="hidden" name="ACCOUNT1" value="{{env("ACCOUNT_CODE")}}">
        <input type="hidden" name="DEPARTMENT_ID" value="{{ $department_id->DEPARTMENT_ID }}">
        <input type="hidden" name="SUB_SYSTEM" value="BOCW">

    </form>

    <form action="{{env('GRAS_PAYMENT_URL')}}/challan/views/frmgrnfordept.php" method="POST" id="payment-submit-form" style="display: none">
        <input type="hidden" id="enc_string" name="PORTAL_ENCDATA">
        <input type="hidden" name="MERCHANT_ID" value="BOCW">
    </form>
{{-- @else
    <form method="post" name="getGRN" id="payment-form"
        action="https://uatgras.assam.gov.in/challan/models/frmgetgrn.php">
        <input type="text" id ="DEPARTMENT_ID" name="DEPARTMENT_ID" value="{{ $department_id->DEPARTMENT_ID }}" />
        <input type="text" id ="OFFICE_CODE" name="OFFICE_CODE" value="LED000" />
        <input type="text" id ="AMOUNT" name="AMOUNT" value="{{ $amount }}" />
        <input type="text" id ="ACTION_CODE" name="ACTION_CODE" value="GETCIN" readonly />
        <input type="text" id ="SUB_SYSTEM" name="SUB_SYSTEM" value="BOCW" />
    </form>
@endif --}}
