@extends('layouts.user-app')

@section('title', ' SOP & GUIDELINES 2')
@section('style')

    <style>
        .table thead th,
        .table tbody td {
            word-wrap: break-word;
            white-space: normal;
        }

        .download {
            background-color: #1b949e !important;
        }

        .table-bordered tr:nth-child(even) {

            background: #f7f3f3;
        }
    </style>

@endsection


@section('content')
    <div class="container">


        <h3 class="mt-4 mb-4 font-weight-500" id="guideline">
            Tenders
            <div class="underline"></div>
        </h3>
        <section class="downloadpage">
            <div class="box">
                <ul>
                    <li>
                        <td class="col-md-12 p-3  align-middle eligibility"
                            data-label="Eligibility criteria & documents required">
                            Notification for EOI 473907-119
                        </td>
                        <a href="{{ route('download', 'Notification_for_EOI_473907-119.pdf') }}">
                            <div class="d-flex justify-content-end"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button></div>
                        </a>
                    </li>
                    <li>
                        <td class="col-md-12 p-3  align-middle eligibility"
                            data-label="Eligibility criteria & documents required">
                            EOI(ABOCWWB-473907_117)
                        </td>
                        <a href="{{ route('download', 'EOI_ABOCWWB-473907_117.pdf') }}">
                            <div class="d-flex justify-content-end"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button></div>
                        </a>
                    </li>
                    <li>
                        <td class="col-md-12 p-3  align-middle eligibility"
                            data-label="Eligibility criteria & documents required">
                            NIQ(524140-09)-Procurement of Laptop
                        </td>
                        <a href="{{ route('download', 'NIQ_524140_09_Procurement_of_Laptop_0.pdf') }}">
                            <div class="d-flex justify-content-end"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button></div>
                        </a>
                    </li>
                    <li>
                        <td class="col-md-12 p-3  align-middle eligibility"
                            data-label="Eligibility criteria & documents required">
                            Short tender notice 13.08.2024
                        </td>
                        <a href="{{ route('download', 'Short_tender_notice_13.08.2024.pdf') }}">
                            <div class="d-flex justify-content-end"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button></div>
                        </a>
                    </li>
                    <li>
                        <td class="col-md-12 p-3  align-middle eligibility"
                            data-label="Eligibility criteria & documents required">
                            Quotation for replacement of Tyre 02.08.2024
                                                </td>
                        <a href="{{ route('download', 'Quotation_for_replacement_of_Tyre_02.08.2024_0.pdf') }}">
                            <div class="d-flex justify-content-end"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button></div>
                        </a>
                    </li>
                    <li>
                        <td class="col-md-12 p-3  align-middle eligibility"
                            data-label="Eligibility criteria & documents required">
                            Notice Inviting Bids-Ref No. 431 (Supply of Goods) 23.09.2023
                        </td>
                        <a href="{{ route('download', 'notice_inviting_bids-ref_no._431_supply_of_goods_23.09.2023.pdf') }}">
                            <div class="d-flex justify-content-end"><button
                                    class="btn download btn-sm"> <i class="fa fa-download" style="color:white"
                                        aria-hidden="true"></i>
                                    <span style="color:white;">Download</span></button></div>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
        {{-- <div class="row m-3">
    <table class="table table-sm table2-bordered ">
        <thead class="headbackground2" style="font-family:'Roboto',Sans-Serif;">
            <tr>
                <th scope="col" class="text-center" style="font-family:'Roboto',Sans-Serif;">Title(download)</th>
                <th scope="col" class="text-center" style="font-family:'Roboto',Sans-Serif;">size</th>
            </tr>
        </thead>
        <tbody style="font-family: 'Roboto', sans-serif;">
            <tr><td class="col-md-12 p-3  align-middle eligibility"
            data-label="Eligibility criteria & documents required">
            Notification for EOI 473907-119
        </td><td class="col-12 p-3 align-middle" data-label="Benefit Amount">
                <a href="{{ route('download', 'Notification_for_EOI_473907-119.pdf') }}"
                   >
                   <div class="d-flex  justify-content-center align-items-center"><button class="btn download btn-sm"> <i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                    <span style="color:white;">Download</span></button></div>
                </a>
            </td></tr>

        </tbody>
    </table>
</div> --}}
    </div>



@endsection


@section('footer')

@endsection


<!-- About Container -->
