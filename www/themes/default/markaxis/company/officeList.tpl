
<div class="tab-pane fade show" id="officeList">
    <div class="list-action-btns office-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalOffice">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_OFFICE?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable officeTable">
        <thead>
        <tr>
            <th><?LANG_OFFICE_NAME?></th>
            <th><?LANG_ADDRESS?></th>
            <th><?LANG_COUNTRY?></th>
            <th><?LANG_WORK_DAYS?></th>
            <th><?LANG_TOTAL_EMPLOYEE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>

<div id="modalOffice" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_OFFICE?></h6>
            </div>

            <form id="saveOffice" name="saveOffice" method="post" action="">
                <input type="hidden" id="officeID" name="officeID" value="0" />
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_OFFICE_NAME?>:</label>
                                <input type="text" name="officeName" id="officeName" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_OFFICE_NAME?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_OFFICE_ADDRESS?>:</label>
                                <input type="text" name="officeAddress" id="officeAddress" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_OFFICE_ADDRESS?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_OFFICE_COUNTRY?>:</label>
                                <?TPL_COUNTRY_LIST?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_OFFICE_TYPE?>:</label>
                                <?TPL_OFFICE_TYPE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_WORKING_DAY_FROM?>:</label>
                                <?TPL_WORK_DAY_FROM?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_WORKING_DAY_TO?>:</label>
                                <?TPL_WORK_DAY_TO?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="checkbox" class="dt-checkboxes check-input" id="main" name="main" value="1" />
                                <label for="main"> &nbsp;Set as main office</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group text-right">
                                <label for="halfDay"><?LANG_LAST_DAY_IS_HALF_DAY?> &nbsp;</label>
                                <input type="checkbox" class="dt-checkboxes check-input" id="halfDay" name="halfDay" value="1" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary" id="saveApplyLeave"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>