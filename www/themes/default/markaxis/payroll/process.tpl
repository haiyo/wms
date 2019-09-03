
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
<form id="employeeForm" class="stepy processEmployee" action="#">
    <input type="hidden" id="processDate" value="<?TPLVAR_PROCESS_DATE?>" />
    <fieldset>
        <legend class="text-semibold">Select Employee to Process Payroll</legend>

        <!--<div class="col-md-3 officeFilter"><?TPL_OFFICE_LIST?></div>-->

        <div class="input-group payroll-range">
            <span class="input-group-prepend">
                <span class="input-group-text">
                    <i class="icon-calendar22"></i> &nbsp;&nbsp;Process Period
                </span>
            </span>
            <input type="text" class="form-control daterange" readonly />
        </div>

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

    <fieldset>
        <legend class="text-semibold">View Summary</legend>

        <table class="table table-hover datatable processedTable">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Gross</th>
                <th>Net</th>
                <th>Claims</th>
                <th>Levies</th>
                <th>Contributions</th>
                <th>Payslips</th>
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
                <th>&nbsp;</th>
            </tr>
            </tfoot>
        </table>
    </fieldset>

    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
        <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
    </button>
</form>