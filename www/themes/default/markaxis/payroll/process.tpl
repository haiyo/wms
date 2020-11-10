
<div id="modalCalPayroll" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_PROCESS_PAYROLL?></h6>
            </div>

            <div class="modal-body overflow-y-visible">

            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                    <button id="savePayroll" type="submit" class="btn btn-primary processBtn"><?LANG_SUBMIT?></button>
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
                    <i class="icon-calendar22"></i> &nbsp;&nbsp;<?LANG_PROCESS_PERIOD?>
                </span>
            </span>
        <input type="text" class="form-control daterange" readonly />
    </div>
    <!-- BEGIN DYNAMIC BLOCK: selectEmployee -->
    <fieldset>
        <legend class="text-semibold"><?LANG_SELECT_EMPLOYEE_TO_PROCESS?></legend>

        <table class="table table-hover datatable employeeTable">
            <thead>
            <tr>
                <th><?LANG_EMPLOYEE_ID?></th>
                <th><?LANG_NAME?></th>
                <th><?LANG_DESIGNATION?></th>
                <th><?LANG_CONTRACT_TYPE?></th>
                <th><?LANG_EMPLOYMENT_STATUS?></th>
                <th><?LANG_ACTIONS?></th>
            </tr>
            </thead>
        </table>
    </fieldset>
    <!-- END DYNAMIC BLOCK: selectEmployee -->
    <fieldset>
        <legend class="text-semibold"><?LANG_SUMMARY?></legend>

        <table class="table table-hover datatable processedTable">
            <thead>
            <tr>
                <th><?LANG_EMPLOYEE?></th>
                <th><?LANG_GROSS?></th>
                <th><?LANG_CLAIM?></th>
                <th><?LANG_LEVY?></th>
                <th><?LANG_CONTRIBUTION?></th>
                <th><?LANG_NET?></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th><?LANG_TOTAL?></th>
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
        <legend class="text-semibold"><?LANG_ACCOUNT_PAYSLIP_RELEASE?></legend>

        <table class="table table-hover datatable finalizedTable">
            <thead>
            <tr>
                <th></th>
                <th><?LANG_EMPLOYEE?></th>
                <th><?LANG_PAYMENT_METHOD?></th>
                <th><?LANG_BANK_NAME?></th>
                <th><?LANG_ACCOUNT_DETAILS?></th>
                <th><?LANG_PAYABLE?></th>
                <th><?LANG_PAYSLIP?></th>
                <th><?LANG_RELEASED?></th>
            </tr>
            </thead>
        </table>
    </fieldset>
    <!-- END DYNAMIC BLOCK: accountDetails -->
    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
        <span class="ladda-label"><?LANG_SUBMIT?> <i class="icon-check position-right"></i></span>
    </button>
</form>
<div id="officeFilter" class="dataFilter" data-countrycode="<?TPLVAR_COUNTRY_CODE?>" data-currency="<?TPLVAR_CURRENCY?>">
    <?TPL_OFFICE_LIST?>
</div>