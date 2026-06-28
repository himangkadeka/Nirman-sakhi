@include('worker.workerFormHeader')

<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info"
                        style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;"><i class="fa fa-user" aria-hidden="true"></i>&nbspPayment Details</h3>
                    <form action="https://uatgras.assam.gov.in/challan/views/frmgrnfordept.php" class="form-group" method="post">

                        @csrf

                        <div class="form-row mt-5"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputFirstName" class="bold">PARTY_NAME/পাৰ্টিৰ নাম</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="PARTY_NAME"
                                       value="EGrass" name="PARTY_NAME" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputLastName" class="bold">Financial Year/বিত্তীয় বৰ্ষ</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="lastname" value="{{old('last_name')}}" name="REC_FIN_YEAR" placeholder="" readonly>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="bold">AMOUNT/পৰিমাণ</label>
                                <input type="text" class="form-control uc-text-smooth" id="AMOUNT1"
                                       value="{{old('gurdain_name')}}" name="AMOUNT1" placeholder="" readonly>

                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="gender" class="bold">Gender</label><span style="color:red;">*</span>--}}
{{--                                <select id="inputGender" class="form-control" name="gender">--}}
{{--                                    <option value="">--Select Gender--</option>--}}
{{--                                    @foreach ($gender as $data)--}}
{{--                                        --}}{{--                                        <option value="" disabled>Select</option>--}}
{{--                                        <option value="{{ $data->gender_code }}">{{ $data->gender_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('gender'))--}}
{{--                                    <span class="text-danger font-weight-normal">{{ $errors->first('gender') }}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
                            <div class="form-group col-md-4">
                                <label for="" class="bold">AC1_AMOUNT/AC1_পৰিমাণ</label>
                                <input type="text" class="form-control" name="AC1_AMOUNT"
                                       placeholder="{{session()->get('AC1_AMOUNT')}}" readonly>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="mStatus" class="bold">TOTAL_NON_TREASURY_AMOUNT/মুঠ নন ট্ৰেজাৰী ধনৰাশি</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" name="TOTAL_NON_TREASURY_AMOUNT"
                                       placeholder="{{session()->get('TOTAL_NON_TREASURY_AMOUNT')}}" readonly>
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4" class="bold">
                                <label for="inputDob" class="bold" style="display: flex;
        align-items: center;">MOBILE_NO/মোবাইল নং</label>
                                <input type="text"  class="form-control" name="MOBILE_NO" value="9090901123">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAge" class="bold">REMARKS/মন্তব্য</label>
                                <input type="text" class="form-control" id="REMARKS" name="REMARKS" value="REMARKS">
                            </div>
                        </div><!--end-->
{{--                        <label for="Payee Name">Payee Name</label>--}}
{{--                        <input type="text" name="PARTY_NAME" value="EGrass">--}}
                        <input type="hidden" name="DEPT_CODE" value="TRA">
                        <input type="hidden" name="PAYMENT_TYPE" value="01">
                        <input type="hidden" name="TREASURY_CODE" value="DIS">
                        <input type="hidden" name="OFFICE_CODE" value="TRA008">
{{--                        <input type="text" name="REC_FIN_YEAR" value="2023-2024">--}}
                        <input type="hidden" name="PERIOD" value="O">
                        <input type="hidden" name="FROM_DATE" value="01/04/2023">
                        <input type="hidden" name="TO_DATE" value="31/03/2099">
                        <input type="hidden" name="MAJOR_HEAD" value="0041">
                        <input type="hidden" name="HOA1" value="0041-00-101-0000-000-40">
{{--                        <input type="text" name="AMOUNT1" value="100">--}}
                        <input type="hidden" name="CHALLAN_AMOUNT" value="100.00">
                        <input type="hidden" name="MULTITRANSFER" value="Y">
                        <input type="hidden" name="NON_TREASURY_PAYMENT_TYPE" value="01">
                        <input type="hidden" name="ACCOUNT1" value="2022">
{{--                        <input type="text" name="AC1_AMOUNT" value="100">--}}
{{--                        <input type="text" name="TOTAL_NON_TREASURY_AMOUNT" value="10">--}}
                        <input type="hidden" name="TAX_ID" value="tin100">
{{--                        <input type="text" name="MOBILE_NO" value="9090909090">--}}
                        <input type="hidden" name="DEPARTMENT_ID" value="WRK0190001">
{{--                        <input type="TEXT" name="REMARKS" value="Registration Fees">--}}
                        <input type="hidden" name="SUB_SYSTEM" value="TRASNS_SARATHI">
                        <input type="submit" value="Submit">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
