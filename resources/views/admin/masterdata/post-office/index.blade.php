@extends('layouts.admin-app')

@section('title', 'Admin | Post-Office')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Post-Office')

@section('content')
    <div class="container-fluid">

        <h4 class="text-left mb-3 ml-5 b-latest-data">POST OFFICE</h4>
        @include('admin.masterdata.post-office.search')
        @include('admin.masterdata.post-office.create')
        @include('admin.masterdata.post-office.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                <h4>Post Office::</h4>
                <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                        data-target="#post-office-add-modal"><button type="button" class="btn btn-primary b-btn"
                            id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                </div>
                <table id="post-office-table" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Post Office</th>
                            <th>Pincode</th>
                            <th>District</th>
                            <th>State</th>
                            <th>Created on</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody></tbody>

                </table>
            </div>
        </div>
    </div>

    <form id="deleteForm" action="{{ route('admin.post-offices.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="post_office_code" id="primary_code_input">
    </form>

@endsection


@section('footer')
    <!-- Additional footer content here (if needed) -->
    <script>
        $('.state_code_select').on('change', function(event) {
            var state_code = $(this).val()
            $.ajax({
                type: 'POST',
                url: "{{ route('master.get-districts-by-state') }}",
                data: {
                    state_code: state_code,
                    _token: csrf
                },
                success: function(response) {
                    if (response.status == false) {
                        console.log(response.results)
                    } else {
                        $(".district_codes").html(response.results);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


        function getDistrict(state_code, district_code) {
            $.ajax({
                type: 'POST',
                url: "{{ route('master.get-districts-by-state') }}",
                data: {
                    state_code: state_code,
                    _token: csrf
                },
                success: function(response) {
                    if (response.status == false) {
                        console.log(response.results)
                    } else {
                        $("#edit_district_code").html(response.results);
                        $("#edit_district_code option").each(function() {
                            if ($(this).val() == district_code) {
                                $(this).prop("selected", true);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }










        // });
    </script>

@endsection
