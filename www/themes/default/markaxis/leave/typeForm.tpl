
<fieldset>
    <legend class="text-semibold"><?LANG_LEAVE_ENTITLEMENT?></legend>

    <div class="row">
        <div class="col-md-4">
            <label><?LANG_LEAVE_TYPE_NAME?>: <span class="text-danger-400">*</span></label>
            <input type="text" name="leaveTypeName" id="leaveTypeName" class="form-control" value="<?TPLVAR_LEAVE_TYPE_NAME?>"
                   placeholder="<?LANG_LEAVE_TYPE_PLACEHOLDER?>" />
        </div>

        <div class="col-md-2">
            <label class="display-block"><?LANG_LEAVE_CODE?>: <span class="text-danger-400">*</span></label>
            <input type="text" name="leaveCode" id="leaveCode" class="form-control" value="<?TPLVAR_LEAVE_TYPE_CODE?>"
                   placeholder="<?LANG_LEAVE_CODE_PLACEHOLDER?>" />
        </div>

        <div class="col-md-3">
            <label class="display-block">&nbsp;</label>
            <?TPL_ALLOW_HALF_DAY_RADIO?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label><?LANG_UNUSED_LIST?>:</label>
            <?TPL_UNUSED_LIST?>
        </div>

        <div class="col-md-2">
            <label><?LANG_CARRY_OVER_LIMIT?>:</label>
            <input type="text" name="cPeriodValue" id="cPeriodValue" class="form-control" value="<?TPLVAR_CPERIOD?>"
                   placeholder="3" disabled="disabled" />
        </div>
        <div class="col-md-2">
            <label>&nbsp;</label>
            <?TPL_CPERIOD_LIST?>
        </div>

        <div class="col-md-2">
            <label><?LANG_TO_BE_USED_WITHIN?>:</label>
            <input type="text" name="usedValue" id="usedValue" class="form-control" value="<?TPLVAR_UPERIOD?>"
                   placeholder="12" disabled="disabled" />
        </div>

        <div class="col-md-2">
            <label>&nbsp;</label>
            <?TPL_USED_PERIOD_LIST?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label><?LANG_PAYROLL_PROCESS_AS?>:</label>
            <?TPL_PAID_LEAVE?>
        </div>

        <div class="col-md-4">
            <label><?LANG_PAYROLL_FORMULA_FOR_UNPAID_LEAVE?>:</label>
            <input type="text" name="formula" id="formula" class="form-control" value="<?TPLVAR_PAYROLL_FORMULA?>" placeholder="" disabled="disabled" />
        </div>

        <div class="col-md-4">
            <label class="display-block"><?LANG_SHOW_CHART_LEAVE_BALANCE?></label>
            <?TPL_SHOW_CHART_RADIO?>
        </div>
    </div>

</fieldset>