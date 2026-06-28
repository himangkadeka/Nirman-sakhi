@extends('layouts.user-app')

@section('title', 'Benefits provided by the board')

@section('style')

    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/benefits.css') }}" />

    <style>
        /* body {
                    font-family: 'Roboto', Sans-Serif;
                } */
    </style>
@endsection

@section('content')
    <div class="container-fluid" style="margin-left: -20px;" id="b-homedb">

        <div class="heading mt-5">
            <h2>{{ trans('benefitsProvidedByTheBoard.head') }}</h2>
            <div class="centerHeading"></div>
        </div>
    </div>

    <div class="container-fluid mt-4 px-5 " style=" font-size:16px;font-family:'Roboto',Sans-Serif;text-align:justify;">
        <p class="aimsandobjectives-body" style=" font-family: 'Roboto', sans-serif;font-size:16px;">
            {{ trans('benefitsProvidedByTheBoard.body') }}
            <br><br>
        <p style="font-weight: 550; margin-left:3px; font-family: 'Roboto', sans-serif;font-size:16px;">
            {{ trans('benefitsProvidedByTheBoard.head') }}</p>
        </p>
    </div>

    <div class="container  mt-3 mb-4">
        <table class="table table-sm table-bordered shadow" style=" font-family: 'Roboto', sans-serif;font-size:16px;">
            <thead class="headbackground">
                <tr>

                    <th scope="col" class="text-center align-middle order-1 px-4"
                        style="color: white; font-family: 'Roboto', sans-serif;font-size:16px;">Sno.</th>
                    <th scope="col" class="col-md-1 text-center align-left p-3 order-2"
                        style="color: white; font-family: 'Roboto', sans-serif;font-size:16px;">
                        {{ trans('benefitsProvidedByTheBoard.tablehead') }}
                    </th>
                    <th scope="col" class="col-md-4 text-center align-middle order-3"
                        style="color: white; font-family: 'Roboto', sans-serif;font-size:16px;">
                        {{ trans('benefitsProvidedByTheBoard.tablehead2') }}
                    </th>
                    <th scope="col" class="col-md-4 text-center align-middle p-3 order-4" style="color: white;">
                        {{ trans('benefitsProvidedByTheBoard.tablehead3') }}
                    </th>
                    <th scope="col" class="text-center align-middle order-5" style="color: white;">
                        {{ trans('benefitsProvidedByTheBoard.tablehead4') }}
                    </th>
                    <th scope="col" class="text-center align-middle order-6" style="color: white;min-width:150px;">E-services
                    </th>
                </tr>


            </thead>
            <tbody style="font-family: 'Roboto', sans-serif;">
                <tr class="">
                    <td class="sno  text-center" style="padding-top: 3.5%;"></td>
                    <td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 600;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.DeathBenefit') }}
                    </td>
                    <td class="text-start p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.DeathBenefittext1') }}

                        <br><br>
                    </td>
                    <td class="col-md-2 p-3  align-left eligibility" data-label="Eligibility criteria & documents required">
                        {!! __('benefitsProvidedByTheBoard.DeathBenefittext2') !!}

                    </td>
                    <td class="col p-3 align-left" data-label="Benefit Amount">
                        {!! __('benefitsProvidedByTheBoard.DeathBenefittext3') !!}





                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="bodycolor">
                    <td class="sno text-center"style="padding-top: 3.5%;"></td><td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 600;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.FuneralAssistance') }}
                    </td>
                    <td class="text-start align-left p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}">
                        <br>{!! __('benefitsProvidedByTheBoard.FuneralAssistancetext1') !!}

                    </td>
                    <td class="col-md-2 p-3  align-left eligibility" data-label="Eligibility criteria & documents required">
                        <br> {!! __('benefitsProvidedByTheBoard.FuneralAssistancetext2') !!}

                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount">
                        <br> {!! __('benefitsProvidedByTheBoard.FuneralAssistancetext3') !!}
                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="">
                    <td class="sno text-center"style="padding-top: 3.5%;"></td> <td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.GeneralPension') }}
                    </td>
                    <td class="text-start align-left p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}">
                        <br>{!! __('benefitsProvidedByTheBoard.GeneralPensiontext1') !!}


                    </td>
                    <td class="col-md-2 p-3 align-left eligibility" data-label="Eligibility criteria & documents required">
                        <br>{!! __('benefitsProvidedByTheBoard.GeneralPensiontext2') !!}

                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount">
                        <br>
                        {{ trans('benefitsProvidedByTheBoard.GeneralPensiontext3') }}
                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="bodycolor">
                    <td class="sno text-center"style="padding-top: 3.5%;"></td> <td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.FamilyPension') }}
                    </td>
                    <td class="text-start align-left p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}">
                        <br>{!! __('benefitsProvidedByTheBoard.FamilyPensiontext1') !!}

                    </td>
                    <td class="col-md-2 p-3 align-left eligibility" data-label="Eligibility criteria & documents required">
                        <br>{!! __('benefitsProvidedByTheBoard.FamilyPensiontext2') !!}

                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount">
                        <br>{!! __('benefitsProvidedByTheBoard.FamilyPensiontext3') !!}

                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="">
                    <td class="sno text-center"style="padding-top: 3.5%;"></td> <td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.DisabilityPension') }}
                    </td>
                    <td class="text-start align-left p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}">
                        <br> {!! __('benefitsProvidedByTheBoard.DisabilityPensiontext1') !!}


                    </td>
                    <td class="col-md-2 p-3 align-left eligibility" data-label="Eligibility criteria & documents required">
                        <br>{!! __('benefitsProvidedByTheBoard.DisabilityPensiontext2') !!}
                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>
                        {{ trans('benefitsProvidedByTheBoard.DisabilityPensiontext3') }}


                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="bodycolor">
                    <td class="sno text-center"style="padding-top: 2.5%;"></td> <td class="col-md-2 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}">
                        <br>
                        {{ trans('benefitsProvidedByTheBoard.TransitShelter') }}
                    </td>
                    <td class="text-start align-left p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}">
                        <br>
                        {{ trans('benefitsProvidedByTheBoard.TransitSheltertext1') }}
                    </td>
                    <td class="col-md-2 p-3 align-left eligibility"
                        data-label="Eligibility criteria & documents required">
                        <br>{!! __('benefitsProvidedByTheBoard.TransitSheltertext2') !!}
                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount">
                        {!! __('benefitsProvidedByTheBoard.TransitSheltertext3') !!}
                        <br>


                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="">
                    <td class="sno text-center"style="padding-top: 3.5%;"></td> <td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.CashAward') }}
                    </td>
                    <td class="text-start align-left p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}">
                        <br> {{ trans('benefitsProvidedByTheBoard.CashAwardtext1') }}
                    </td>
                    <td class="col-md-2 p-3 align-left eligibility"
                        data-label="Eligibility criteria & documents required">
                        <br> {!! __('benefitsProvidedByTheBoard.CashAwardtext2') !!}
                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>
                        {{ trans('benefitsProvidedByTheBoard.CashAwardtext3') }}


                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="bodycolor">
                    <td class="sno text-center"style="padding-top: 2.5%;"></td> <td class="col-md-2  text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.OneTimeEducationalAssistance') }}
                    </td>
                    <td class="text-start align-left p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.OneTimeEducationalAssistancetext1') }}

                    </td>
                    <td class="col-md-2 px-3 align-left eligibility"
                        data-label="Eligibility criteria & documents required"> <br>
                        {!! __('benefitsProvidedByTheBoard.OneTimeEducationalAssistancetext2') !!} </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>

                        {!! __('benefitsProvidedByTheBoard.OneTimeEducationalAssistancetext3') !!}









                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="">
                    <td class="sno text-center"style="padding-top: 3.5%;"></td> <td class="col-md-2 p-3 text-center align-left"
                        style="font-family:'Roboto',Sans-Serif;font-weight: 600;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.MedicalAssistance') }}
                    </td>
                    <td class="text-start p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}"><br>
                        {!! __('benefitsProvidedByTheBoard.MedicalAssistancetext1') !!}


                    </td>
                    <td class="col-md-2 px-3 align-left eligibility"
                        data-label="Eligibility criteria & documents required"><br> {!! __('benefitsProvidedByTheBoard.MedicalAssistancetext2') !!}

                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>


                        {!! __('benefitsProvidedByTheBoard.MedicalAssistancetext3') !!}









                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="bodycolor">
                    <td class="sno text-center"style="padding-top: 2.5%;"></td><td class="col-md-2 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.MaternityAssistance') }}
                    </td>
                    <td class="text-start p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}"><br>
                        {!! __('benefitsProvidedByTheBoard.MaternityAssistancetext1') !!}


                    </td>
                    <td class="col-md-2 px-3 eligibility" data-label="Eligibility criteria & documents required"><br>
                        {!! __('benefitsProvidedByTheBoard.MaternityAssistancetext2') !!} </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>
                        {!! __('benefitsProvidedByTheBoard.MaternityAssistancetext3') !!}


















                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="">
                    <td class="sno text-center"style="padding-top: 3%;"></td><td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.SkillDevelopmentTraining') }}
                    </td>
                    <td class="text-start p-3" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}"><br>
                        {!! __('benefitsProvidedByTheBoard.SkillDevelopmentTrainingtext1') !!}

                    </td>
                    <td class="col-md-2 px-3 eligibility" data-label="Eligibility criteria & documents required"><br>

                        {!! __('benefitsProvidedByTheBoard.SkillDevelopmentTrainingtext2') !!}

                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>
                        {!! __('benefitsProvidedByTheBoard.SkillDevelopmentTrainingtext3') !!}





















                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                <tr class="bodycolor">
                    <td class="sno text-center"style="padding-top: 3.5%;"></td><td class="col-md-2 p-3 text-center align-left"
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.MarriageAssistance') }}
                    </td>
                    <td class="text-start p-3 align-left" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}"><br>
                        {!! __('benefitsProvidedByTheBoard.MarriageAssistancetext1') !!}

                    </td>
                    <td class="col-md-2 px-3 eligibility" data-label="Eligibility criteria & documents required"><br>
                        {!! __('benefitsProvidedByTheBoard.MarriageAssistancetext2') !!}
                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>
                        {!! __('benefitsProvidedByTheBoard.MarriageAssistancetext3') !!}



















                    </td>
                    <td class="text-center text-success" style="padding-top: 3%;">Launching Soon</td>
                </tr>

                {{-- <tr class="">
                    <td class="col-md-2 p-3 align-left "
                        style=" font-family: 'Roboto', sans-serif;font-size:16px;font-weight: 550;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.CovidAssistance') }}
                    </td>
                    <td class="text-start p-3  align-left" style=" font-family: 'Roboto', sans-serif;font-size:16px;"
                        data-label="{{ trans('benefitsProvidedByTheBoard.tablehead2') }}"><br>
                        {{ trans('benefitsProvidedByTheBoard.text13') }}
                    </td>
                    <td class="col-md-2 px-3 align-left eligibility"
                        data-label="Eligibility criteria & documents required"><br>
                        NA

                        <br>

                    </td>
                    <td class="col-12 p-3 align-left" data-label="Benefit Amount"><br>
                        Rs.2000/-




                    </td>

                </tr> --}}
                <!-- Repeat for other rows -->
            </tbody>
        </table>
    </div>
@endsection

@section('footer')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all table rows
        const rows = document.querySelectorAll('tbody tr');

        // Initialize separate counters for sno, snopension, and snomaternity
        let snoIndex = 1;

        rows.forEach((row) => {
            // Find and set serial number for "sno" class
            const snoCell = row.querySelector('.sno');
            if (snoCell) {
                snoCell.textContent = snoIndex++;
            }


                 });
    });
</script>
@endsection
