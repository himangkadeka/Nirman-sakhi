@extends('layouts.admin-app')

@section('title', 'Admin | Districts')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Districts')

@section('content')
<div class="container-fluid">
    @can('create district')
    <h4 class="text-left mb-3 ml-5 b-latest-data">ADD DISTRICT</h4>

    @include('admin.masterdata.district.create')
    @endcan

    <div class="col-md-12 p-5 table-responsive">
        <h4>Districts::</h4>
        <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
            <thead class="thead-dark">
                <tr>
                    <th>Sno.</th>
                    <th>District Code</th>
                    <th>State Name</th>
                    <th>District Name</th>
                    <th>Created On</th>
                    @can('update district')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($districts as $district)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$district->district_code}}</td>
                    <td>{{$district->state->state_name}}</td>
                    <td>{{$district->district_name}}</td>
                    <td>{{$district->created_at}}</td>
                    @can('update district')
                    <td>
                        <span>

                            <button data-toggle="modal" data-target="#edit-district-modal" aria-hidden="true" onclick="editDistrict('{{$district->district_code}}','{{$district->state_code}}','{{$district->district_name}}')" style="border: none; background: none; padding: 0; cursor: pointer;">
                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                            </button>

                            <a href="javascript:void(0);" onclick="confirmUpdate('{{ $district->district_code }}', '{{ $district->status }}')" style="text-decoration: none; color: '{{ $district->status ? '#28a745' : '#ee1b1b' }}'">
                                <i class="fas fa-toggle-{{ $district->status ? 'on' : 'off' }}" style="color: '{{ $district->status ? '#28a745' : '#ee1b1b' }}'; padding-left:5px;"></i>
                            </a>

                            {{-- <a href="{{ route('delete.district', ['district_code' => $district->district_code]) }}" onclick="return confirm('Are you sure you want to delete this District?')" style="text-decoration: none; color: #ee1b1b;">
                            <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                            </a> --}}
                        </span>
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Activation/ Deactivation -->
<form id="updateDistrictForm" action="{{ route('admin.districts.status') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="district_code" id="district_code_input">
    <input type="hidden" name="status" id="status_input">
</form>

@include('admin.masterdata.district.edit')
<script>
    function confirmUpdate(districtCode, status) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to change the status of the District.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Update the form values
                document.getElementById('district_code_input').value = districtCode;
                document.getElementById('status_input').value = status==1 ? 0 : 1;

                // Submit the form
                document.getElementById('updateDistrictForm').submit();
            }
        });
    }
</script>
@endsection

@section('footer')

@endsection
