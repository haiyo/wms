
<script src="https://nightly.datatables.net/select/js/dataTables.select.js?_=9a6592f8d74f8f520ff7b22342fa1183"></script>

<div class="d-md-flex">

    <div class="panel panel-flat">
        <div class="panel-body">

            <div class="content-wrapper side-content-wrapper rp">
                <form id="irasForm" class="stepy" action="#">
                    <input type="hidden" id="tfID" name="tfID" value="<?TPLVAR_TAXFILE_ID?>" />
                    <fieldset>
                        <legend class="text-semibold"><?LANG_IRAS_FORM?></legend>

                        <div class="row">
                            <div class="col-md-3">
                                <label><?LANG_FILE_TAX_FOR_YEAR?>: <span class="text-danger-400">*</span></label>
                                <?TPL_YEAR_LIST?>
                            </div>

                            <div class="col-md-3">
                                <label><?LANG_SELECT_OFFICE?>: <span class="text-danger-400">*</span></label>
                                <?TPL_OFFICE_LIST?>
                            </div>
                            <div class="col-md-3">
                                <label><?LANG_SELECT_SOURCE_TYPE?>: <span class="text-danger-400">*</span></label>
                                <?TPL_SOURCE_TYPE_LIST?>
                            </div>
                            <div class="col-md-3">
                                <label><?LANG_ORGANISATION_ID_TYPE?>: <span class="text-danger-400">*</span></label>
                                <?TPL_ORG_ID_LIST?>
                            </div>
                            <!--<div class="col-md-3">
                                <label><?LANG_SELECT_AUTHORIZED?>: <span class="text-danger-400">*</span></label>
                                <?TPL_OFFICE_LIST?>
                            </div>-->
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label><?LANG_ORGANISATION_ID_NUMBER?>: <span class="text-danger-400">*</span></label>
                                <input disabled="disabled" class="form-control" value="<?TPLVAR_REG_NUMBER?>" />
                            </div>

                            <div class="col-md-3">
                                <label><?LANG_ORGANISATION_NAME?>: <span class="text-danger-400">*</span></label>
                                <input disabled="disabled" class="form-control" value="<?TPLVAR_COMPANY_NAME?>" />
                            </div>

                            <div class="col-md-3">
                                <label><?LANG_SELECT_PAYMENT_TYPE?>: <span class="text-danger-400">*</span></label>
                                <?TPL_PAYMENT_TYPE_LIST?>
                            </div>

                            <div class="col-md-3">
                                <label class="display-block"><?LANG_FILE_BATCH_INDICATOR?>: <span class="text-danger-400">*</span></label>
                                <?TPL_BATCH_RADIO?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h7 class="mb-0 ml-10 font-weight-bold"><?LANG_AUTHORISED_SUBMITTING_PERSONNEL?>:</h7>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><?LANG_AUTHORISED_NAME?>: <span class="text-danger-400">*</span></label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?TPLVAR_NAME?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><?LANG_DESIGNATION?>: <span class="text-danger-400">*</span></label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?TPLVAR_DESIGNATION?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mobile Number: <span class="text-danger-400">*</span></label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?TPLVAR_MOBILE?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><?LANG_EMAIL?>: <span class="text-danger-400">*</span></label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?TPLVAR_EMAIL?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </fieldset>

                    <fieldset>
                        <legend class="text-semibold"><?LANG_SELECT_EMPLOYEE?></legend>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover datatable employeeTable">
                                    <thead>
                                    <tr>
                                        <th class="text-center dt-checkboxes-cell dt-checkboxes-select-all sorting_disabled">
                                            <input type="checkbox">
                                        </th>
                                        <th><?LANG_EMPLOYEE_ID?></th>
                                        <th><?LANG_NAME?></th>
                                        <th><?LANG_DESIGNATION?></th>
                                        <th><?LANG_CONTRACT_TYPE?></th>
                                        <th><?LANG_EMPLOYMENT_STATUS?></th>
                                        <th><?LANG_ACTIONS?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-semibold"><?LANG_DECLARATION_FOR_INDIVIDUAL_EMPLOYEE?></legend>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover datatable declareTable">
                                    <thead>
                                    <tr>
                                        <th><?LANG_EMPLOYEE?></th>
                                        <th>IR8A</th>
                                        <th>A8A</th>
                                        <th>A8B</th>
                                        <th>IR8S</th>
                                        <th>IR21</th>
                                        <th>IR21A</th>
                                        <th><?LANG_ACTIONS?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
                        <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modalIR8A" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Edit Form IR8A</h6>
            </div>

            <form id="saveIr8a" name="saveIr8a" method="post" action="">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button id="submitIr8a" type="submit" class="btn btn-primary"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalA8A" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Edit Form Appendix 8A</h6>
            </div>

            <form id="saveIra8a" name="saveIra8a" method="post" action="">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button id="submitIra8a" type="submit" class="btn btn-primary"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>