
<fieldset style="display: none;">
    <legend class="text-semibold">Finance &amp; Leave</legend>

    <div class="row">
        <div class="col-md-4">
            <label>Assign Payroll Calendar:</label>
            <?TPL_PAYROLL_CAL_LIST?>
        </div>
        <div class="col-md-4">
            <label>Assign Tax Group:</label>
            <?TPL_TAX_GROUP_LIST?>
        </div>
        <div class="col-md-4">
            <label>Assign Leave Type:</label>
            <?TPL_LEAVE_TYPE_LIST?>
        </div>
    </div>

    <div class="row">
        <span class="mb-0 ml-10 font-weight-bold">Employee Payment Details:</span>
        <div class="card">
            <div class="card-body">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Payment Method:</label>
                        <?TPL_PAYMENT_METHOD_LIST?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank:</label>
                        <?TPL_BANK_LIST?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Account Number:</label>
                        <input type="text" name="bankNumber" placeholder="123-456-789" class="form-control" value="<?TPLVAR_BANK_NUMBER?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Code:</label>
                        <input type="text" name="bankCode" placeholder="7171" class="form-control" value="<?TPLVAR_BANK_CODE?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Branch Code:</label>
                        <input type="text" name="bankBranchCode" placeholder="081" class="form-control" value="<?TPLVAR_BANK_BRANCH_CODE?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Account Holder's Name:</label>
                        <input type="text" name="bankHolderName" placeholder="Bank Account Holder's Name" class="form-control" value="<?TPLVAR_BANK_HOLDER_NAME?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Swift Code:</label>
                        <input type="text" name="bankSwiftCode" placeholder="DBSSSGSG" class="form-control" value="<?TPLVAR_SWIFT_CODE?>" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</fieldset>