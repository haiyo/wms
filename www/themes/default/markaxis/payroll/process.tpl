
<div id="modalCalPayroll" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Process Payroll</h6>
            </div>

            <div class="modal-body overflow-y-visible">

            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                    <button id="savePayroll" type="submit" class="btn btn-primary processBtn">Save Payroll</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalPayment" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Payment</h6>
            </div>

            <div class="modal-body modal-payment overflow-y-visible">

            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                    <button id="savePayroll" type="submit" class="btn btn-primary processBtn">Payment</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="employeeForm" class="stepy processEmployee" action="#">
    <input type="hidden" id="processDate" value="<?TPLVAR_PROCESS_DATE?>" />
    <input type="hidden" id="completed" value="<?TPLVAR_COMPLETED?>" />
    <input type="hidden" id="pID" value="<?TPLVAR_PID?>" />

    <div class="input-group payroll-range">
            <span class="input-group-prepend">
                <span class="input-group-text">
                    <i class="icon-calendar22"></i> &nbsp;&nbsp;Process Period
                </span>
            </span>
        <input type="text" class="form-control daterange" readonly />
    </div>
    <!-- BEGIN DYNAMIC BLOCK: selectEmployee -->
    <fieldset>
        <legend class="text-semibold">Select Employee to Process Payroll</legend>

        <!--<div class="col-md-3 officeFilter"><?TPL_OFFICE_LIST?></div>-->

        <table class="table table-hover datatable employeeTable">
            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Contract Type</th>
                <th>Employment Status</th>
                <th>Actions</th>
            </tr>
            </thead>
        </table>
    </fieldset>
    <!-- END DYNAMIC BLOCK: selectEmployee -->
    <fieldset>
        <legend class="text-semibold">Summary</legend>

        <table class="table table-hover datatable processedTable">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Gross</th>
                <th>Claim</th>
                <th>Levy</th>
                <th>Contribution</th>
                <th>Net</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Total</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            </tfoot>
        </table>
    </fieldset>
    <!-- BEGIN DYNAMIC BLOCK: accountDetails -->
    <fieldset>
        <legend class="text-semibold">Account &amp; Payslip Release</legend>

        <table class="table table-hover datatable finalizedTable">
            <thead>
            <tr>
                <th></th>
                <th>Employee</th>
                <th>Payment Method</th>
                <th>Bank Name</th>
                <th>Account Detail</th>
                <th>Payable</th>
                <th>Payslip</th>
                <th>Released</th>
            </tr>
            </thead>
        </table>
    </fieldset>
    <!-- END DYNAMIC BLOCK: accountDetails -->
    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
        <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
    </button>
</form>