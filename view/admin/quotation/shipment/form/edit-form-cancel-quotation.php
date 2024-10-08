<div class="card-body border rounded border-danger" style="background-color: #FCEEEE">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="d-flex justify-content-center align-items-center mt-3">
                <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 100px; height: 100px; background: #fecfcd">
                    <i class="fas fa-exclamation-triangle text-danger fa-3x"></i>
                </div>
            </div>
            <div class="text-center mt-4">
                <h5 class="text-danger font-weight-bold">Ada pemintaan pembatalan dari Sales</h5>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="row">
                <div class="col-md-6">Tanggal Permintaan</div>
                <div class="col-md-6">
                    <div id="request_cancel_date"></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">Pemohon</div>
                <div class="col-md-6">
                    <div id="request_cancel_sales_name"></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">Alasan Pembatalan</div>
                <div class="col-md-6">
                    <div id="request_cancel_reason"></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary w-100 mb-0 mt-3" data-toggle="modal" data-target="#modal_reject_cancel_requested">Reject</button>
                    <div class="modal fade" id="modal_reject_cancel_requested" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <a href="javascript:;" data-dismiss="modal" class="close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 100px; height: 100px; background: #F6E7CB">
                                            <i class="fas fa-question-circle text-warning fa-3x"></i>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <h3 class="text-danger font-weight-bold">Konfirmasi!</h3>
                                        <p>Apakah Anda yakin untuk me-reject permintaan pembatalan Quotation ini? Jika Ya, maka Quotation dapat digunakan kembali</p>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger px-4" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary px-4" onclick="updateHdQuoShipmentsRejectCancel(<?php echo $_GET['id'] ?>)">Ya, Yakin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-danger w-100 mb-0 mt-3" data-toggle="modal" data-target="#modal_approve_cancel_requested">Approve</button>
                    <div class="modal fade" id="modal_approve_cancel_requested" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <a href="javascript:;" data-dismiss="modal" class="close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 100px; height: 100px; background: #F6E7CB">
                                            <i class="fas fa-question-circle text-warning fa-3x"></i>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <h3 class="text-danger font-weight-bold">Konfirmasi!</h3>
                                        <p>Apakah Anda yakin untuk membatalkan Quotation ini? Jika Ya, maka Quotation tidak bisa digunakan kembali</p>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger px-4" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary px-4" onclick="updateHdQuoShipmentsApproveCancel(<?php echo $_GET['id'] ?>)">Ya, Yakin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>