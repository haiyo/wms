<span style="color:#666;">Only fill in the blanks where applicable.<br />
    (i) Disabled fields are auto generated information based on Year <?TPLVAR_YEAR?> payroll, no changes can be made.<br />
    (ii) If you have fields marked in red, please fill them up by editing the company or employee information in Company / Employee Settings.<br />
    (iii) If you are making Amendments, please only fill up the difference in amount. Refer to <a href="https://www.iras.gov.sg/irashome/uploadedFiles/IRASHome/Businesses/Amendment%20Guide.pdf" target="=_blank">IRAS Submitting an Amendment File</a>.<br />
    (iv) If you need help understanding how to fill up the IR8A form, refer to <a href="https://www.iras.gov.sg/irashome/Quick-Links/Forms/Businesses/Income-Tax-forms-for-Employers/" target="=_blank">IRAS explanatory notes</a>.<br />
    (v) If you think any information is inaccurate, please do not hesitate to contact support.</span>
<div class="display-block" style="border-top:1px solid #ccc;margin: 5px 0 25px;"></div>
<input type="hidden" id="tfID" name="tfID" value="<?TPLVAR_TFID?>" />
<input type="hidden" id="userID" name="userID" value="<?TPLVAR_USERID?>" />
<div class="row">
    <div class="col-md-4">
        <label>Employer’s Tax Ref. No. / UEN: <span class="text-danger-400">*</span></label>
        <input type="text" name="empRef" id="empRef" class="form-control" value="<?TPLVAR_EMP_REF?>" />
    </div>

    <div class="col-md-4">
        <label>Employee’s Tax Ref. No.: <span class="text-danger-400">*</span></label>
        <input type="text" name="empIDNo" id="empIDNo" class="form-control" value="<?TPLVAR_EMP_ID?>" />
    </div>

    <div class="col-md-4">
        <label>Full Name of Employee as per NRIC / FIN: <span class="text-danger-400">*</span></label>
        <input type="text" name="empName" id="empName" class="form-control" value="<?TPLVAR_EMP_NAME?>" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>Employee Date Of Birth: <span class="text-danger-400">*</span></label>
        <div class="form-group">
            <div class="col-md-4 no-padding-left">
                <div class="form-group">
                    <?TPL_DOB_MONTH_LIST?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?TPL_DOB_DAY_LIST?>
                </div>
            </div>
            <div class="col-md-4 no-padding-right">
                <div class="form-group">
                    <input type="number" name="dobYear" id="dobYear" class="form-control" value="<?TPLVAR_DOB_YEAR?>" placeholder="Year" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label>Nationality: <span class="text-danger-400">*</span></label>
        <?TPL_NATIONALITY_LIST?>
    </div>

    <div class="col-md-4">
        <label class="display-block">Gender: <span class="text-danger-400">*</span></label>
        <?TPL_GENDER_RADIO?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>Residential Address: <span class="text-danger-400">*</span></label>
        <input type="text" name="address" id="address" class="form-control" value="<?TPLVAR_ADDRESS?>" />
    </div>

    <div class="col-md-4">
        <label>Designation: <span class="text-danger-400">*</span></label>
        <input type="text" name="designation" id="designation" class="form-control" value="<?TPLVAR_DESIGNATION?>" />
    </div>

    <div class="col-md-4">
        <label>Bank to which salary is credited: <span class="text-danger-400">*</span></label>
        <input type="text" name="bankName" id="bankName" class="form-control" value="<?TPLVAR_BANK_NAME?>" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>Date of Commencement:</label>
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
                    <input type="number" name="startYear" class="form-control" value="<?TPLVAR_START_YEAR?>" placeholder="Year" disabled="disabled" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label>Date of Cessation:</label>
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
                    <input type="number" name="endYear" class="form-control" value="<?TPLVAR_END_YEAR?>" placeholder="Year" disabled="disabled" />
                </div>
            </div>
        </div>
    </div>

</div>

<strong class="select2-results__group iras_group">Income</strong>

<div class="row">
    <div class="col-md-4">
        <label>Gross Salary:</label>
        <input type="number" name="gross" class="form-control" value="<?TPLVAR_SALARY?>" disabled="disabled" />
    </div>

    <div class="col-md-4">
        <label>Bonus:</label>
        <input type="number" name="bonus" class="form-control" value="<?TPLVAR_BONUS?>" disabled="disabled" />
    </div>

    <div class="col-md-4">
        <label>Director's fees:</label>
        <input type="number" name="directorFee" class="form-control" value="<?TPLVAR_DIRECTOR_FEES?>" disabled="disabled" />
    </div>
</div>

<strong class="select2-results__group iras_group">Others</strong>

<div class="row">
    <div class="col-md-4">
        <label>Transport Allowance:</label>
        <input type="number" name="transport" class="form-control" value="<?TPLVAR_TRANSPORT?>" disabled="disabled" />
    </div>

    <div class="col-md-4">
        <label>Entertainment Allowance:</label>
        <input type="number" name="entertainment" class="form-control" value="<?TPLVAR_ENTERTAINMENT?>" disabled="disabled" />
    </div>

    <div class="col-md-4">
        <label>Other Allowance:</label>
        <input type="number" name="allowance" class="form-control" value="<?TPLVAR_OTHER_ALLOWANCE?>" disabled="disabled" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>Gross Commission Period From:</label>
        <div class="form-group">
            <div class="col-md-4 no-padding-left">
                <div class="form-group">
                    <?TPL_COMM_FROM_MONTH_LIST?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?TPL_COMM_FROM_DAY_LIST?>
                </div>
            </div>
            <div class="col-md-4 no-padding-right">
                <div class="form-group">
                    <input type="number" name="commFromYear" class="form-control" placeholder="Year" value="<?TPLVAR_COMM_FROM_YEAR?>" disabled="disabled" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label>Gross Commission Period To:</label>
        <div class="form-group">
            <div class="col-md-4 no-padding-left">
                <div class="form-group">
                    <?TPL_COMM_TO_MONTH_LIST?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?TPL_COMM_TO_DAY_LIST?>
                </div>
            </div>
            <div class="col-md-4 no-padding-right">
                <div class="form-group">
                    <input type="number" name="dobYear" class="form-control" placeholder="Year" value="<?TPLVAR_COMM_TO_YEAR?>" disabled="disabled" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label>Commission Payment Type:</label>
        <?TPL_COMM_PAYMENT_TYPE?>
    </div>

</div>

<div class="row">
    <div class="col-md-4">
        <label>Total Commission:</label>
        <input type="number" name="totalComm" class="form-control" value="<?TPLVAR_TOTAL_COMM?>" disabled="disabled" />
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h7 class="mb-0 ml-10 font-weight-bold">Lump Sum Payment:</h7>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Gratuity:</label>
                        <input type="number" name="gratuity" class="form-control" value="<?TPLVAR_GRATUITY?>" disabled="disabled" />
                    </div>
                    <div class="col-md-4">
                        <label>Notice Pay:</label>
                        <input type="number" name="notice" class="form-control" value="<?TPLVAR_NOTICE_PAY?>" disabled="disabled" />
                    </div>
                    <div class="col-md-4">
                        <label>Ex-gratia payment:</label>
                        <input type="number" name="exGratia" class="form-control" value="<?TPLVAR_EX_GRATIA?>" disabled="disabled" />
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <label>Others:</label>
                        <input type="number" name="otherLumpSum" class="form-control" value="<?TPLVAR_OTHER_LUMP_SUM?>" placeholder="Enter amount" disabled="disabled" />
                    </div>
                    <div class="col-md-8">
                        <label>If others, please state nature:</label>
                        <input type="text" name="otherLumpSumRemark" class="form-control" value="<?TPLVAR_OTHER_LUMP_SUM_REMARK?>" />
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <label>Compensation for loss of office:</label>
                        <input type="number" name="compensation" class="form-control" value="<?TPLVAR_COMPENSATION?>" placeholder="Enter amount" />
                    </div>

                    <div class="col-md-4">
                        <label class="display-block">Approval obtained from IRAS:</label>
                        <?TPL_IRAS_APPROVED_RADIO?>
                    </div>

                    <div class="col-md-4">
                        <label>Date of approval:</label>
                        <div class="form-group">
                            <div class="col-md-4 no-padding-left">
                                <div class="form-group">
                                    <?TPL_APPROVED_MONTH_LIST?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?TPL_APPROVED_DAY_LIST?>
                                </div>
                            </div>
                            <div class="col-md-4 no-padding-right">
                                <div class="form-group">
                                    <input type="number" name="approvedYear" class="form-control" value="<?TPLVAR_APPROVED_YEAR?>" placeholder="Year" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label>Reason for payment:</label>
                        <input type="text" name="reasonPayment" class="form-control" value="<?TPLVAR_REASON_PAYMENT?>" />
                    </div>
                    <div class="col-md-4">
                        <label>Length of service:</label>
                        <input type="text" name="lengthService" class="form-control" value="<?TPLVAR_LENGTH_SERVICE?>" disabled="disabled" />
                    </div>
                    <div class="col-md-4">
                        <label>Basis of arriving at the payment:</label>
                        <input type="text" name="basisPayment" class="form-control" value="<?TPLVAR_BASIS_PAYMENT?>" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>Retirement benefits Pension/Provident Fund:</label>
        <input type="text" name="retireFundName" class="form-control" value="<?TPLVAR_RETIRE_FUND_NAME?>" />
    </div>

    <div class="col-md-4">
        <label>Amount accrued up to 31 Dec 1992:</label>
        <input type="number" name="amtAccrued92" class="form-control" value="<?TPLVAR_ACCRUED92?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>Amount accrued from 1993:</label>
        <input type="number" name="amtAccrued93" class="form-control" value="<?TPLVAR_ACCRUED93?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <label>Contributions made by employer outside Singapore <strong><u>without</u></strong> tax concession:</label>
        <input type="number" name="contriOutSGWithoutTax" class="form-control" value="<?TPLVAR_CONTRI_WITHOUT_TAX?>" placeholder="Enter amount" />
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <h7 class="mb-0 ml-10 font-weight-bold">Contributions made by employer outside Singapore <strong><u>with</u></strong> tax concession:</h7>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <label>Name of the overseas pension/provident fund:</label>
                        <input type="text" name="overseasFundName" class="form-control" value="<?TPLVAR_OVERSEAS_FUND_NAME?>" />
                    </div>
                    <div class="col-md-4">
                        <label>Full Amount of the contributions:</label>
                        <input type="text" name="overseasFundAmt" class="form-control" value="<?TPLVAR_OVERSEAS_FUND_AMT?>" placeholder="Enter amount" />
                    </div>
                    <div class="col-md-3">
                        <label>Are contributions mandatory:</label>
                        <?TPL_CONTRI_MAND_RADIO?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>Were contributions charged / deductions claimed by a Singapore permanent establishment:</label>
                        <?TPL_CONTRI_CHARGED_RADIO?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <label> Excess/Voluntary contribution to CPF by employer (less amount refunded/to be refunded):</label>
        <input type="number" name="excessContriByEmployer" class="form-control" value="<?TPLVAR_EXCESS_CONTRI?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Gains or profits from Employee Stock Option (ESOP):</label>
        <input type="number" name="gainsProfitESOP" class="form-control" value="<?TPLVAR_GAINS_PROFIT?>" disabled="disabled" placeholder="Enter amount" />
    </div>

    <div class="col-md-6">
        <label>Value of Benefits-in-kind [Complete Appendix 8A]:</label>
        <input type="number" id="benefitsInKind" name="benefitsInKind" class="form-control" value="<?TPLVAR_BENEFITS_IN_KIND?>" placeholder="Enter amount" />
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <label>Exempt Indicator:</label>
        <?TPL_EXEMPT_INDICATOR?>
    </div>

    <!--<div class="col-md-4">
        <label class="display-block">Overseas Posting:</label>
        <?TPL_OVERSEAS_POSTING_RADIO?>
    </div>-->

    <div class="col-md-6">
        <label>Exempt Income:</label>
        <input type="number" name="exemptIncome" class="form-control" value="<?TPLVAR_EXEMPT_INCOME?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h7 class="mb-0 ml-10 font-weight-bold">Employee’s income tax borne by employer? <?TPL_TAX_BORNE_RADIO?></h7>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>If tax is partially borne by employer, state the amount of income for which tax is borne by employer:</label>
                        <input type="number" name="employerTaxBorne" class="form-control" value="<?TPLVAR_EMP_TAX_BORNE?>" placeholder="Enter amount" />
                    </div>
                    <div class="col-md-6">
                        <label>If a fixed amount of tax is borne by employee, state the amount of tax to be paid by employee:</label>
                        <input type="number" name="empTaxPaid" class="form-control" value="<?TPLVAR_EMP_TAX_PAID?>" placeholder="Enter amount" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<strong class="select2-results__group iras_group">Deductions</strong>

<div class="row">
    <div class="col-md-4">
        <label>Employee's compulsory contribution to:</label>
        <input type="text" name="deductFundName" class="form-control" value="<?TPLVAR_DEDUCT_FUND_NAME?>" disabled="disabled" />
    </div>
    <div class="col-md-4">
        <label>Fund Amount:</label>
        <input type="number" name="cpf" class="form-control" value="<?TPLVAR_CPF?>" disabled="disabled" />
    </div>
    <div class="col-md-4">
        <label>Donations (SINDA/CDAC/ECF etc):</label>
        <input type="number" name="donation" class="form-control" value="<?TPLVAR_DONATIONS?>" disabled="disabled" />
    </div>
</div>


<div class="row">
    <div class="col-md-4">
        <label>Contributions to Mosque Building Fund:</label>
        <input type="number" name="contriMosque" class="form-control" value="<?TPLVAR_CONTRI_MOSQUE?>" placeholder="Enter amount" />
    </div>
    <div class="col-md-4">
        <label>Life Insurance premiums:</label>
        <input type="number" name="insurance" class="form-control" value="<?TPLVAR_INSURANCE?>" placeholder="Enter amount" />
    </div>
</div></div>