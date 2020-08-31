
<div class="tab-pane fade" id="holidayList">
    <div class="list-action-btns holiday-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalHoliday" data-backdrop="static" data-keyboard="false">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_CUSTOM_HOLIDAY?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable holidayTable">
        <thead>
        <tr>
            <th><?LANG_TITLE?></th>
            <th><?LANG_COUNTRY?></th>
            <th><?LANG_DATE?></th>
            <th><?LANG_WORK_DAY?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>

<div id="modalHoliday" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_CUSTOM_HOLIDAY?></h6>
            </div>

            <form id="saveHoliday" name="saveHoliday" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="hID" name="hID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_HOLIDAY_TITLE?>:</label>
                                <input type="text" name="holidayTitle" id="holidayTitle" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_HOLIDAY_TITLE?>" />
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label><?LANG_DATE?>: <span class="requiredField">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate" id="date" name="date" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label></label>
                                <div class="input-group" style="margin-top: 13px;">
                                    <input type="checkbox" class="dt-checkboxes check-input" id="workDay" name="workDay" value="1" />
                                    <label for="workDay" class="ml-5"><?LANG_IS_THIS_WORK_DAY?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>