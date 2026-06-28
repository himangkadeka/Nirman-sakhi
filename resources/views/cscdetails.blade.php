@extends('layouts.user-app')

@section('title', 'CSC Details')

@section('content')
    <div class="container-fluid" id="b-homedb">
        <div class="heading mt-3">
            <h2>{{ trans('header.cscdetails') }}</h2>
            <div class="centerHeading"></div>
        </div>
    </div>

    <div class="container-fluid" id="b-homedb">
        <div class="d-flex justify-content-center py-3">
            {{-- <table id="cscTable" class="table table-bordered text-sm-center"> --}}
                  <table id="abaocTable" class="table table-bordered text-sm-center">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>CSCID</th>
                        <th>VLEName</th>
                        <th>District</th>
                        <th>SubDistrict</th>
                        <th>GP</th>
                        <th>Village</th>
                        <th>Locality</th>

                    </tr>
                </thead>
                <tbody id="csc-list">
                    @foreach ($cscdetails as $csc)
                        <tr data-district-code="{{ $csc->district }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $csc->cscid }}</td>
                            <td>{{ $csc->vlename }}</td>
                            <td>{{ $csc->district }}</td>

                            <td>{{ $csc->subdistrict }}</td>
                            <td>{{ $csc->gp }}</td>
                            <td>{{ $csc->village }}</td>
                            <td>{{ $csc->locality }}</td>
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
            const cscList = document.getElementById("csc-list");
            const allRows = Array.from(cscList.querySelectorAll("tr"));
            const button = document.querySelector("button"); // Show all button

            button.addEventListener("click", function(event) {
                event.preventDefault();
                allRows.forEach(row => row.style.display = "");
            });

            districtSelect.addEventListener("change", function() {
                const selectedCode = this.value;
                allRows.forEach(row => {
                    row.style.display = (row.dataset.districtCode === selectedCode) ? "" : "none";
                });
            });
        });
    </script>
@endsection
