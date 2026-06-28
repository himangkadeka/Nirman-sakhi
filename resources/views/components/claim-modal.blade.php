<div class="modal fade" id="claim-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block  border-bottom-0 bg-success">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('claim-modal.apply') }}</h5>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!---Worker Register ---->
                    <div class="tab-pane container active" id="workerRegister">
                        <div id="workerrenewalmsg"></div>
                        <div class="form-group">
                            <div class="modal-body d-flex justify-content-center align-items-center">
                                <h3>{{ trans('claim-modal.undermaintenance') }}</h3>
                            </div>
                            <div class="modal-body d-flex justify-content-center align-items-center">
                                <a href="{{ route('home.benefits') }}" class="text-primary">{{ trans('claim-modal.clickhere1') }}</a>{{ trans('claim-modal.clickhere2') }}<a href="{{ route('home.benefits') }}" class="text-primary">{{ trans('claim-modal.clickhere3') }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
