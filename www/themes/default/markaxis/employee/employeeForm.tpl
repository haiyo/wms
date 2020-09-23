
<fieldset style="display: none;">
    <legend class="text-semibold"><?LANG_EMPLOYEE_SETUP?></legend>
    <div class="row">
        <div class="col-md-2">
            <label><?LANG_EMPLOYEE_ID?>: <span class="text-danger-400">*</span></label>
            <input type="text" name="idnumber" id="idnumber" placeholder="0000000" class="form-control" value="<?TPLVAR_IDNUMBER?>" />
        </div>

        <div class="col-md-4">
            <label><?LANG_ASSIGN_DEPARTMENT?>:</label>
            <?TPL_DEPARTMENT_LIST?>
        </div>

        <div class="col-md-6">
            <label><?LANG_OFFICE_LOCATION?>:</label>
            <?TPL_OFFICE_LIST?>
        </div>


    </div>

    <div class="row">
        <div class="col-md-6">
            <label><?LANG_ASSIGN_DESIGNATION?>:</label>
            <?TPL_DESIGNATION_LIST?>
        </div>

        <div class="col-md-6">
            <label><?LANG_ASSIGN_MANAGERS?>:</label>
            <input type="text" name="managers" id="managers" class="form-control tokenfield-typeahead suggestList"
                   placeholder="<?LANG_ENTER_MANAGER_NAME?>"
                   value="" autocomplete="off" data-fouc />
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <label><?LANG_ASSIGN_ROLE?>:</label>
            <?TPL_ROLE_LIST?>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label><?LANG_BASIC_SALARY?>:</label>
                <input type="text" name="salary" placeholder="5000" class="form-control amountInput" value="<?TPLVAR_SALARY?>" />
            </div>
        </div>

        <div class="col-md-3">
            <label><?LANG_CONTRACT_TYPE?>:</label>
            <?TPL_CONTRACT_LIST?>
        </div>

        <!--<div class="col-md-3">
            <div class="form-group">
                <label><?LANG_SALARY_TYPE?>:</label>
                <?TPL_SALARY_TYPE?>
            </div>
        </div>-->

        <div class="col-md-6 mb-30">
            <label><?LANG_EMPLOYMENT_CONFIRM_DATE?>:</label>
            <div class="form-group">

                <div class="col-md-4 no-padding-left">
                    <div class="form-group">
                        <?TPL_CONFIRM_MONTH_LIST?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <?TPL_CONFIRM_DAY_LIST?>
                    </div>
                </div>

                <div class="col-md-4 no-padding-right">
                    <div class="form-group">
                        <input type="number" name="confirmYear" class="form-control" placeholder="<?LANG_YEAR?>" value="<?TPLVAR_CONFIRM_YEAR?>" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <label><?LANG_EMPLOYMENT_START_DATE?>:</label>
            <div class="form-group">
                <div class="col-md-4 no-padding-left">
                    <div class="form-group">
                        <?TPL_START_MONTH_LIST?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <?TPL_START_DAY_LIST?>
                    </div>
                </div>

                <div class="col-md-4 no-padding-right">
                    <div class="form-group">
                        <input type="number" name="startYear" class="form-control" placeholder="<?LANG_YEAR?>" value="<?TPLVAR_START_YEAR?>" />
                    </div>
                </div>
            </div>
        </div>


        <!--<div class="col-md-6">
            <label><?LANG_EMPLOYMENT_END_DATE?>:</label>
            <div class="form-group">
                <div class="col-md-4 no-padding-left">
                    <div class="form-group">
                        <?TPL_END_MONTH_LIST?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <?TPL_END_DAY_LIST?>
                    </div>
                </div>

                <div class="col-md-4 no-padding-right">
                    <div class="form-group">
                        <input type="number" name="endYear" class="form-control" placeholder="<?LANG_YEAR?>" value="<?TPLVAR_END_YEAR?>" />
                    </div>
                </div>
            </div>
        </div>-->

        <div class="col-md-6 competency-tt-menu">
                <label><?LANG_ADD_EMPLOYEE_COMPETENCIES?>: <i class="icon-info22 mr-3" data-popup="tooltip" title="" data-html="true"
                                                     data-original-title="<?LANG_COMPETENCY_INFO?>"></i>
                    <span class="text-muted">(<?LANG_TYPE_ADD_NEW_COMPETENCY?>)</span></label>
                <input type="text" name="competency" id="competency" class="form-control tokenfield-typeahead competencyList"
                       placeholder="<?LANG_ENTER_SKILLSETS_KNOWLEDGE?>"
                       value="" autocomplete="off" data-fouc />
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <h7 class="mb-0 ml-10 font-weight-bold"><?LANG_FOR_FOREIGNER?>:</h7>
            <div class="card">
                <div class="card-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?LANG_WORK_PASS_TYPE?>:</label>
                            <?TPL_PASS_TYPE_LIST?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?LANG_WORK_PASS_NUMBER?>:</label>
                            <input type="text" name="passNumber" placeholder="0 325269 42" class="form-control" value="<?TPLVAR_PASS_NUMBER?>" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?LANG_WORK_PASS_EXPIRY_DATE?>:</label>
                            <div class="row">
                                <div class="col-md-4 no-padding-left">
                                    <div class="form-group">
                                        <?TPL_PASS_EXPIRY_MONTH_LIST?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?TPL_PASS_EXPIRY_DAY_LIST?>
                                    </div>
                                </div>

                                <div class="col-md-4 no-padding-right">
                                    <div class="form-group">
                                        <input type="number" name="passExpiryYear" class="form-control" placeholder="<?LANG_YEAR?>" value="<?TPLVAR_PASS_EXPIRY_YEAR?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
