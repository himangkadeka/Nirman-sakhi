@extends('layouts.admin-app')

@section('title', 'Admin | Sub-District')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Sub-District')

@section('content')

    <div class="col-md-12 p-5 table-responsive">
        <h4>SUB DISTRICTS</h4>

        @can('create subdistrict')
            <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                    data-target="#sub-district-add-modal"><button type="button" class="btn btn-primary b-btn"
                        onclick="clearFormFields()">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a></div>
        @endcan
        <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
            <thead class="thead-dark">
                <tr>
                    <th>Sno.</th>
                    <th>Sub District Code</th>
                    <th>Sub District</th>
                    <th>District</th>
                    <th>State</th>
                    <th>Created AT</th>
                    @can('update subdistrict')
                        <th>Action</th>
                    @elsecan('delete subdistrict')
                        <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($subdistricts as $subdistrict)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subdistrict->subdistrict_code }}</td>
                        <td>{{ $subdistrict->subdistrict_name }}</td>
                        <td>{{ $subdistrict->district->district_name }}</td>
                        <td>{{ $subdistrict->state->state_name }}</td>
                        <td>{{ $subdistrict->created_at }}</td>
                        <td>
                            <span>
                                @can('update subdistrict')
                                    <button data-toggle="modal" data-target="#edit-sub-district-modal" aria-hidden="true"
                                        onclick="editSubdistrict('{{ $subdistrict->subdistrict_code }}','{{ $subdistrict->subdistrict_name }}','{{ $subdistrict->district_code }}','{{ $subdistrict->state_code }}')"
                                        style="border: none; background: none; padding: 0; cursor: pointer;">
                                        <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                    </button>
                                @endcan
                                @can('dekete subdistrict')
                                    <button onclick="confirmDelete('{{ $subdistrict->subdistrict_code }}','Sub-District')"
                                        style="border: none; background: none; padding: 0; cursor: pointer;">
                                        <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                                    </button>
                                @endcan
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('admin.masterdata.sub-district.create')
    @include('admin.masterdata.sub-district.edit')

    <form id="deleteForm" action="{{ route('admin.sub-districts.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="sub_district_code" id="primary_code_input">
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
    </script>

@endsection
