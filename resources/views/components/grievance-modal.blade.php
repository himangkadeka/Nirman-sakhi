<div class="modal fade" id="grievance-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block  border-bottom-0 bg-success">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('grivance.grivanceregistration') }}</h5>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <!-- Tab panes -->
                <div class="">
                    <!---Worker Register ---->
                    <div class="tab-pane container active" id="workerRegister">
                        <div id="workerrenewalmsg"></div>
                        <div class="form-group">
                            <div class="modal-body d-flex justify-content-center align-items-center">
                                <h2>{{ trans('grivance.undermaintenance') }}</h2>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
