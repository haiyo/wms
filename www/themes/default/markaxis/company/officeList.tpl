
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
            <th>Office Name</th>
            <th>Address</th>
            <th>Country</th>
            <th>Work Days</th>
            <th>Total Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>

<div id="modalOffice" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Office</h6>
            </div>

            <form id="saveOffice" name="saveOffice" method="post" action="">
                <input type="hidden" id="officeID" name="officeID" value="0" />
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Name:</label>
                                <input type="text" name="officeName" id="officeName" class="form-control" value=""
                                       placeholder="Enter Office Name" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Address:</label>
                                <input type="text" name="officeAddress" id="officeAddress" class="form-control" value=""
                                       placeholder="Enter Office Address" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Country:</label>
                                <?TPL_COUNTRY_LIST?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Type:</label>
                                <?TPL_OFFICE_TYPE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Working Day From:</label>
                                <?TPL_WORK_DAY_FROM?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Working Day To:</label>
                                <?TPL_WORK_DAY_TO?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <label>Last day is half day: &nbsp;</label>
                                <input type="checkbox" class="dt-checkboxes check-input" id="halfDay" name="halfDay" value="1" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveApplyLeave">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>