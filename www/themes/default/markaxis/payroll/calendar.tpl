
<div class="tab-pane fade show active" id="calendars">
    <div class="list-action-btns calendars-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modalAddPayCal">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_PAY_CALENDAR?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable payCalTable">
        <thead>
        <tr>
            <th><?LANG_NAME?></th>
            <th><?LANG_PAY_PERIOD?></th>
            <th><?LANG_PAYMENT_CYCLE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalAddPayCal" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_PAY_CALENDAR?></h6>
            </div>

            <form id="savePayCal" name="savePayCal" method="post" action="">
            <div class="modal-body overflow-y-visible">
                <input type="hidden" id="pcID" name="pcID" value="0" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?LANG_HOW_OFTEN_PAY?></label>
                            <?TPL_PAY_PERIOD_LIST?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?LANG_PAY_RUN_TITLE?>:</label>
                            <input type="text" name="title" id="title" class="form-control" value=""
                                   placeholder="<?LANG_MONTHLY_WEEKLY?>" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label><?LANG_NEXT_PAYMENT_DATE?>:</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                            </span>
                            <input type="text" class="form-control pickadate-paymentDate" id="paymentDate" name="paymentDate" placeholder="" />
                        </div>
                    </div>

                    <div class="col-md-6 hide" id="paymentCycle">
                        <label><?LANG_PAYMENT_CYCLE_DATE?>:</label>
                        <span class="help-block paymentDateHelp"></span>
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