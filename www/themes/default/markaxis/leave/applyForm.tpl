<div id="modalApplyLeave" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Apply Leave</h6>
            </div>

            <form id="applyLeaveForm" name="applyLeaveForm" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Leave Type:</label>
                                <?TPL_LEAVE_TYPE_LIST?>
                            </div>
                        </div>

                        <!--<div class="col-md-6">
                            <div class="form-group">
                                <label>Leave For:</label>
                                <?TPL_APPLY_FOR_LIST?>
                            </div>
                        </div>-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reason:</label>
                                <input type="text" name="reason" id="reason" class="form-control" value=""
                                       placeholder="For e.g: Personal issues, Vacation" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date:</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate-start" id="startDate" name="startDate" placeholder="" />

                                    <span class="input-group-prepend ml-10">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control" id="startTime" name="startTime" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>End Date:</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                </span>
                                <input type="text" class="form-control pickadate-end" id="endDate" name="endDate" placeholder="" />

                                <span class="input-group-prepend ml-10">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                <input type="text" class="form-control" id="endTime" name="endTime" placeholder="" />
                            </div>
                        </div>

                        <!--<div class="col-md-12 mt-20 mb-20">
                            <div class="input-group">
                                <label>Does this period consist of half day leave?</label>
                                <input type="checkbox" id="halfDay" name="halfDay" class="form-check-input-styled" />
                            </div>
                        </div>-->

                        <div id="dateHelpWrapper" class="col-md-12 hide">
                            <div class="form-group">
                                <span id="daysHelp" class="help-block"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Approving Manager(s):</label>
                                <input type="text" id="managerList" name="managers" class="form-control tokenfield-typeahead managerList"
                                       placeholder="Enter Manager's Name"
                                       value="" autocomplete="off" data-fouc />
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