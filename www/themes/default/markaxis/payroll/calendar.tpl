
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
            <th>Name</th>
            <th>Pay Period</th>
            <th>Next Payment Date</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalAddPayCal" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Pay Calendar</h6>
            </div>

            <form id="savePayCal" name="savePayCal" method="post" action="">
            <div class="modal-body overflow-y-visible">
                <input type="hidden" id="pcID" name="pcID" value="0" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>How often will you pay your employees?</label>
                            <?TPL_PAY_PERIOD_LIST?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Pay Run Title:</label>
                            <input type="text" name="title" id="title" class="form-control" value=""
                                   placeholder="For e.g: Monthly Full-time Employee, Weekly Part-time Employee" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>Next Payment Date:</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                            </span>
                            <input type="text" class="form-control pickadate-paymentDate" id="paymentDate" name="paymentDate" placeholder="" />
                        </div>
                    </div>

                    <div class="col-md-6 hide" id="paymentCycle">
                        <label>Payment Cycle Date:</label>
                        <span class="help-block paymentDateHelp"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>