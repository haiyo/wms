
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
            <?TPL_PAID_LEAVE?>
        </div>

        <div class="col-md-3">
            <label class="display-block">&nbsp;</label>
            <?TPL_ALLOW_HALF_DAY_RADIO?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label><?LANG_LEAVE_CAN_BE_APPLIED?>:</label>
            <?TPL_APPLIED_LIST?>
        </div>

        <div class="col-md-2">
            <label><?LANG_PROBATION_PERIOD?>:</label>
            <input type="text" name="pPeriodValue" id="pPeriodValue" class="form-control" value="<?TPLVAR_PPERIOD?>" placeholder="3" disabled="disabled" />
        </div>

        <div class="col-md-2">
            <label>&nbsp;</label>
            <?TPL_PPERIOD_LIST?>
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
        <span class="mb-0 ml-10 font-weight-bold"><?LANG_APPLICABLE_TO?>:</span>
        <div class="card">
            <div class="card-body">

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="display-block"><?LANG_CHILD_BORN_IN?>:</label>
                        <?TPL_CHILD_COUNTRY_LIST?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="display-block"><?LANG_CHILD_MAX_AGE?>:</label>
                        <?TPL_CHILD_AGE_LIST?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</fieldset>