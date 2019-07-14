
<fieldset style="display: none;">
    <legend class="text-semibold">Employee Setup</legend>
    <div class="row">
        <div class="col-md-2">
            <label>Employee ID: <span class="text-danger-400">*</span></label>
            <input type="text" name="idnumber" id="idnumber" placeholder="0000000" class="form-control" value="<?TPLVAR_IDNUMBER?>" />
        </div>

        <div class="col-md-4">
            <label>Select Department:</label>
            <?TPL_DEPARTMENT_LIST?>
        </div>

        <div class="col-md-3">
            <label>Office / Location:</label>
            <?TPL_OFFICE_LIST?>
        </div>

        <div class="col-md-3">
            <label>Contract Type:</label>
            <?TPL_CONTRACT_LIST?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label>Assign Designation:</label>
            <?TPL_DESIGNATION_LIST?>
        </div>

        <div class="col-md-6">
            <label>Assign Manager(s):</label>
            <input type="text" name="managers" id="managers" class="form-control tokenfield-typeahead suggestList"
                   placeholder="Enter Manager's Name"
                   value="" autocomplete="off" data-fouc />
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <label>Assign Role(s):</label>
            <?TPL_ROLE_LIST?>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Basic Salary:</label>
                <input type="text" name="salary" placeholder="5000" class="form-control amountInput" value="<?TPLVAR_SALARY?>" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Salary Type:</label>
                <?TPL_SALARY_TYPE?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Employment Confirmation Date:</label>
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
                            <input type="number" name="confirmYear" class="form-control" placeholder="Year" value="<?TPLVAR_CONFIRM_YEAR?>" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label>Employment Start Date:</label>
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
                            <input type="number" name="startYear" class="form-control" placeholder="Year" value="<?TPLVAR_START_YEAR?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <label>Employment End Date:</label>
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
                        <input type="number" name="endYear" class="form-control" placeholder="Year" value="<?TPLVAR_END_YEAR?>" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 competency-tt-menu">
                <label>Add Employee Competencies: <i class="icon-info22 mr-3" data-popup="tooltip" title="" data-html="true"
                                                     data-original-title="<?LANG_COMPETENCY_INFO?>"></i>
                    <span class="text-muted">(Type and press Enter to add new competency)</span></label>
                <input type="text" name="competency" id="competency" class="form-control tokenfield-typeahead competencyList"
                       placeholder="Enter skillsets or knowledge"
                       value="" autocomplete="off" data-fouc />
        </div>

    </div>

    <div class="row">
        <h6 class="mb-0 ml-10 font-weight-bold">For Foreigner:</h6>
        <div class="card">
            <div class="card-body">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Work Pass Type:</label>
                        <?TPL_PASS_TYPE_LIST?>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Work Pass Number:</label>
                        <input type="text" name="passNumber" placeholder="0 325269 42" class="form-control" value="<?TPLVAR_PASS_NUMBER?>" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Work Pass Expiry Date:</label>
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
                                    <input type="number" name="passExpiryYear" class="form-control" placeholder="Year" value="<?TPLVAR_PASS_EXPIRY_YEAR?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
