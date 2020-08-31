
<fieldset style="display: none;">
    <legend class="text-semibold"><?LANG_FINANCE_LEAVE?></legend>

    <div class="row">
        <div class="col-md-4">
            <label><?LANG_ASSIGN_PAYROLL_CALENDAR?>:</label>
            <?TPL_PAYROLL_CAL_LIST?>
        </div>
        <div class="col-md-4">
            <label><?LANG_ASSIGN_TAX_GROUP?>:</label>
            <div id="taxGroupList"><?TPL_TAX_GROUP_LIST?></div>
        </div>
        <div class="col-md-4">
            <label><?LANG_ASSIGN_LEAVE_TYPE?>:</label>
            <?TPL_LEAVE_TYPE_LIST?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h7 class="mb-0 ml-10 font-weight-bold"><?LANG_EMPLOYEE_PAYMENT_DETAILS?>:</h7>
            <div class="card">
                <div class="card-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_PAYMENT_METHOD?>:</label>
                            <?TPL_PAYMENT_METHOD_LIST?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_BANK?>:</label>
                            <?TPL_BANK_LIST?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_BANK_ACCOUNT_NUMBER?>:</label>
                            <input type="text" name="bankNumber" placeholder="123-456-789" class="form-control" value="<?TPLVAR_BANK_NUMBER?>" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_BANK_CODE?>:</label>
                            <input type="text" name="bankCode" placeholder="7171" class="form-control" value="<?TPLVAR_BANK_CODE?>" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_BANK_BRANCH_CODE?>:</label>
                            <input type="text" name="bankBranchCode" placeholder="081" class="form-control" value="<?TPLVAR_BANK_BRANCH_CODE?>" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_BANK_ACCOUNT_NAME?>:</label>
                            <input type="text" name="bankHolderName" placeholder="<?LANG_BANK_ACCOUNT_NAME?>" class="form-control" value="<?TPLVAR_BANK_HOLDER_NAME?>" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_BANK_SWIFT_CODE?>:</label>
                            <input type="text" name="bankSwiftCode" placeholder="DBSSSGSG" class="form-control" value="<?TPLVAR_SWIFT_CODE?>" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</fieldset>