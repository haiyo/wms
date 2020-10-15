
<div class="d-md-flex">

    <div class="panel panel-flat">
        <div class="panel-body">

            <div class="content-wrapper side-content-wrapper rp">
                <form id="leaveTypeForm" class="stepy" action="#">
                    <fieldset>
                        <legend class="text-semibold"><?LANG_IRAS_FORM?></legend>

                        <div class="row">
                            <div class="col-md-4">
                                <label><?LANG_FILE_TAX_FOR_YEAR?>: <span class="text-danger-400">*</span></label>
                                <?TPL_YEAR_LIST?>
                            </div>

                            <div class="col-md-4">
                                <label><?LANG_SELECT_OFFICE?>: <span class="text-danger-400">*</span></label>
                                <?TPL_OFFICE_LIST?>
                            </div>
                            <div class="col-md-4">
                                <label><?LANG_SELECT_AUTHORIZED?>: <span class="text-danger-400">*</span></label>
                                <?TPL_OFFICE_LIST?>
                            </div>
                        </div>

                    </fieldset>

                    <fieldset>
                        <legend class="text-semibold"><?LANG_SELECT_EMPLOYEE?></legend>
                    </fieldset>

                    <fieldset>
                        <legend class="text-semibold"><?LANG_DECLARATION_FOR_INDIVIDUAL_EMPLOYEE?></legend>

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

                            <div class="col-md-3">
                                <label class="display-block"><?LANG_MONTHLY_BASIS?></label>
                                <?TPL_PRO_RATED_RADIO?>
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
                    </fieldset>
                    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
                        <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>