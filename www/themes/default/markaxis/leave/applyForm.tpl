<div id="modalApplyLeave" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_APPLY_LEAVE?></h6>
            </div>

            <form id="applyLeaveForm" name="applyLeaveForm" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="laID" name="laID" value="0" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_LEAVE_TYPE?>: <span class="requiredField">*</span></label>
                                <?TPL_LEAVE_TYPE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_REASON?>:</label>
                                <input type="text" name="reason" id="reason" class="form-control" value=""
                                       placeholder="<?LANG_PERSONAL_ISSUES_VACATION?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_START_DATE?>: <span class="requiredField">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate-start" id="startDate" name="startDate" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_END_DATE?>: <span class="requiredField">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate-end" id="endDate" name="endDate" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-checkbox-group">
                                <input type="checkbox" class="dt-checkboxes check-input" id="firstHalf" name="firstHalf" value="1" />
                                <label for="firstHalf" class="ml-5"><?LANG_HALF_DAY_ON_FIRST_DAY?></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <input type="checkbox" class="dt-checkboxes check-input" id="secondHalf" name="secondHalf" value="1" />
                            <label for="secondHalf" class="ml-5"><?LANG_HALF_DAY_ON_LAST_DAY?></label>
                        </div>

                        <div id="dateHelpWrapper" class="col-md-12 hide">
                            <div class="form-group">
                                <span id="daysHelp" class="help-block"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="display-block"><?LANG_UPLOAD_SUPPORTING_DOCUMENT?>:</label>
                                <div class="input-group">
                                    <input type="file" class="fileInput" data-fouc />
                                    <span class="help-block"><?LANG_ACCEPTED_FORMATS?> <?TPLVAR_MAX_ALLOWED?></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label><?LANG_APPROVING_MANAGERS?>:</label>
                            <input type="text" name="managers" class="form-control tokenfield-typeahead suggestList"
                                   placeholder="<?LANG_ENTER_MANAGER_NAME?>"
                                   value="" autocomplete="off" data-fouc />
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