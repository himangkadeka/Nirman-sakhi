@extends('layouts.admin-app')

@section('title', 'Admin | State')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'States')

@section('content')
    <div class="container-fluid">

        @can('create state')
            <h4 class="text-left mb-3 ml-5 b-latest-data">ADD STATE</h4>
            @include('admin.masterdata.state.create')
        @endcan



        <div class="col-md-12 p-5 table-responsive">
            <h4>States::</h4>
            <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">

                <thead class="thead-dark">

                    <tr>

                        <th>S.No.</th>

                        <th>State Code</th>

                        <th>State Name</th>

                        <th>Created At</th>

                        @can('update state')
                            <th>Action</th>
                        @endcan
                    </tr>

                </thead>

                <tbody>

                    @foreach ($states as $state)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $state->state_code }}</td>

                            <td>{{ $state->state_name }}</td>

                            <td>{{ $state->created_at }}</td>

                            @can('update state')
                                <td>
                                    <span>
                                        <button data-toggle="modal" data-target="#edit-state-modal" aria-hidden="true"
                                            onclick="editState('{{ $state->state_code }}','{{ $state->state_name }}')"
                                            style="border: none; background: none; padding: 0; cursor: pointer;">
                                            <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                        </button>

                                        <!-- Toggle State with Slider Symbol -->
                                        <a href="javascript:void(0);"
                                            onclick="confirmUpdate('{{ $state->state_code }}', '{{ $state->status }}')"
                                            style="text-decoration: none; color: '{{ $state->status ? '#28a745' : '#ee1b1b' }}'">
                                            <i class="fas fa-toggle-{{ $state->status ? 'on' : 'off' }}"
                                                style="color: '{{ $state->status ? '#28a745' : '#ee1b1b' }}'; padding-left:5px;"></i>
                                        </a>
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
    <form id="updateStateForm" action="{{ route('admin.states.status') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="state_code" id="state_code_input">
        <input type="hidden" name="status" id="status_input">
    </form>

    @include('admin.masterdata.state.edit')

    <script>
        function confirmUpdate(stateCode, status) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to change the status of the state.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Update the form values
                    document.getElementById('state_code_input').value = stateCode;
                    document.getElementById('status_input').value = status == 1 ? 0 : 1;

                    // Submit the form
                    document.getElementById('updateStateForm').submit();
                }
            });
        }
    </script>

@endsection

@section('footer')
    <!-- Additional footer content here (if needed) -->


@endsection
