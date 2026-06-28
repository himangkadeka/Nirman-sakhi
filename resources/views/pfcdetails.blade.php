@extends('layouts.user-app')


{{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> --}}

@section('title', 'PFC name and Postal Address')


@section('style')
    <style>
        /* .cardhead2 {
                                            background: linear-gradient(to right, #076f6b, #279ca0);
                                        } */

        .download {
            background-color: #009cdb;
            !important;


        }
    </style>

@endsection


@section('content')

    <div class="container-fluid" id="b-homedb">



        <div class="heading mt-3">
            <h2 style=" ">
                {{ trans('header.pfcdetails') }}

            </h2>
            <div class="centerHeading"></div>
        </div>
    </div>

    <div class="container-fluid" id="b-homedb">

        
        <div class="d-flex justify-content-center py-3">




            <table id="abaocTable" class="table table-bordered text-sm-center">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>{{ trans('pfcdetails.districtname') }}</th>
                        <th>{{ trans('pfcdetails.PFCName') }}</th>
                        <th>{{ trans('pfcdetails.PostalAddress') }}</th>
                        <th>{{ trans('pfcdetails.PinCode') }}</th>
                        <th>{{ trans('pfcdetails.NearbyLandmark') }}</th>
                        <th>{{ trans('pfcdetails.Latitude') }}</th>
                        <th>{{ trans('pfcdetails.Longitude') }}</th>
                        <th>{{ trans('pfcdetails.DistrictCode') }}</th>
                    </tr>
                </thead>
                <tbody id="pfc-list">
                    @foreach ($pfcdetails as $pfcdetail)
                        <tr data-district-code="{{ $pfcdetail->district_code }}">
                            <td scope="row" class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->districts->district_name ?? 'N/A' }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->pfc_name }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->postal_address }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->pin_code }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->nearby_landmark }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->latitude }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->longitude }}</td>
                            <td class="text-center align-middle">{{ $pfcdetail->district_code }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
@endsection


@section('footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const districtSelect = document.getElementById("bank_name_search_select");
            const pfcList = document.getElementById("pfc-list");
            const allRows = Array.from(pfcList.querySelectorAll("tr"));
            const button = document.querySelector("button"); // Target the "Click Me!" button

            // Function to show all districts when the button is clicked
            button.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent the form from submitting
                allRows.forEach(row => {
                    row.style.display = ""; // Show all rows
                });
            });

            // Function to filter rows based on district selection
            districtSelect.addEventListener("change", function() {
                const selectedCode = this.value;

                // Filter rows
                allRows.forEach(row => {
                    if (row.dataset.districtCode === selectedCode) {
                        row.style.display = ""; // Show matching row
                    } else {
                        row.style.display = "none"; // Hide non-matching rows
                    }
                });
            });
        });
    </script>




@endsection
