<!-- Edit State Modal -->
<div class="modal fade" id="edit-state-modal">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">

                <h4 class="text-light">EDIT STATE</h4>

                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>

            </div>
            <!-- Modal Body -->

            <div class="modal-body">

                <form action="{{ route('admin.states.update') }}" method="post" id="edit-state-form" class="w-sm-100 w-auto mx-auto needs-validation master-data-form" novalidate>

                    @csrf

                    <div class="form-group w-100">

                        <label for="edit-state_code">State Code*:</label>

                        <input type="text" class="form-control" id="edit-state-code" name="state_code" pattern="[0-9]+" placeholder="Enter State" value="old('state_code')" readonly>

                    </div>

                    <div class="form-group w-100">

                        <label for="edit-state-name">State Name*:</label>

                        <input type="text" class="form-control" id="edit-state-name" name="state_name" pattern="[A-Za-z]+" placeholder="Enter State" value="{{ old('state_name') }}" required>





                        <span class="invalid-feedback" id="state_name_error"></span>


                    </div>

                    <div class="d-flex justify-content-center py-4">

                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
