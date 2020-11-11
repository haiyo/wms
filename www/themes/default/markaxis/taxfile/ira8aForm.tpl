<span style="color:#666;">Only fill in the blanks where applicable.<br />
    (i) Disabled fields are auto generated information based on Year <?TPLVAR_YEAR?> payroll, no changes can be made.<br />
    (ii) Please make sure the amount you entered tally with the Total Value of Benefits-In-Kind.
</span>
<div class="display-block" style="border-top:1px solid #ccc;margin: 5px 0 25px;"></div>
<input type="hidden" id="tfID" name="tfID" value="<?TPLVAR_TFID?>" />
<input type="hidden" id="userID" name="userID" value="<?TPLVAR_USERID?>" />

<div class="row">
    <div class="col-md-6">
        <label>Full Name of Employee as per NRIC / FIN:</label>
        <input type="text" name="empName" id="empName8A" class="form-control" value="<?TPLVAR_EMP_NAME?>" />
    </div>

    <div class="col-md-6">
        <label>Employee’s Tax Ref. No.:</label>
        <input type="text" name="empIDNo" id="empIDNo8A" class="form-control" value="<?TPLVAR_EMP_ID?>" />
    </div>
</div>

<strong class="select2-results__group iras_group">1. Place of Residence provided by Employer</strong>

<div class="row">
    <div class="col-md-6">
        <label>Residential Address: <span class="text-danger-400">*</span></label>
        <input type="text" name="address" id="address" class="form-control" value="<?TPLVAR_ADDRESS?>" />
    </div>

    <div class="col-md-3">
        <label>No. of days: <span class="text-danger-400">*</span></label>
        <input type="number" name="days" id="days" class="form-control" value="<?TPLVAR_DAYS?>" />
    </div>

    <div class="col-md-3">
        <label>No. of employee(s) sharing: <span class="text-danger-400">*</span></label>
        <input type="number" name="numberShare" id="numberShare" class="form-control" value="<?TPLVAR_NUMBER_SHARE?>" />
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <label>Period of occupation (From): <span class="text-danger-400">*</span></label>
        <div class="form-group">
            <div class="col-md-4 no-padding-left">
                <div class="form-group">
                    <?TPL_FROM_MONTH_LIST?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?TPL_FROM_DAY_LIST?>
                </div>
            </div>
            <div class="col-md-4 no-padding-right">
                <div class="form-group">
                    <input type="number" name="fromYear" id="fromYear" class="form-control" value="<?TPLVAR_FROM_YEAR?>" placeholder="Year" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <label>Period of occupation (To): <span class="text-danger-400">*</span></label>
        <div class="form-group">
            <div class="col-md-4 no-padding-left">
                <div class="form-group">
                    <?TPL_TO_MONTH_LIST?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?TPL_TO_DAY_LIST?>
                </div>
            </div>
            <div class="col-md-4 no-padding-right">
                <div class="form-group">
                    <input type="number" name="toYear" id="toYear" class="form-control" value="<?TPLVAR_TO_YEAR?>" placeholder="Year" />
                </div>
            </div>
        </div>
    </div>
</div>

<strong class="select2-results__group iras_group">2. Accommodation and related benefits provided by Employer</strong>

<div class="row">
    <div class="col-md-4">
        <label>(a) Annual Value of Premises for the period:</label>
        <input type="number" id="annualValue" name="annualValue" class="form-control" value="<?TPLVAR_ANNUAL_VALUE?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(b) Value of Furniture &amp; Fitting:</label>
        <input type="number" id="furnitureValue" name="furnitureValue" class="form-control" value="<?TPLVAR_FURNITURE_VALUE?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(c) Rent paid by employer:</label>
        <input type="number" id="rentPaidEmployer" name="rentPaidEmployer" class="form-control" value="<?TPLVAR_RENT_PAID_EMPLOYER?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>(d) Taxable Value of Residence : (2a+2b) or 2c:</label>
        <input type="number" id="taxableValue" name="taxableValue" class="form-control" value="<?TPLVAR_TAXABLE_VALUE?>" placeholder="(2a+2b) or 2c" disabled="disabled" />
    </div>

    <div class="col-md-4">
        <label>(e) Total Rent paid by employee for Residence:</label>
        <input type="number" id="rentPaidEmployee" name="rentPaidEmployee" class="form-control" value="<?TPLVAR_RENT_PAID_EMPLOYEE?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(f) Total Taxable Value of Residence (2d-2e):</label>
        <input type="number" id="totalTaxablePlace" name="totalTaxablePlace" class="form-control" value="<?TPLVAR_TOTAL_TAXABLE_PLACE?>" placeholder="(2d-2e)" disabled="disabled" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>(g) Utilities/Phone/Electronic (e.g. Laptop):</label>
        <input type="number" id="utilities" name="utilities" class="form-control" value="<?TPLVAR_UTILITIES?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(h) Driver - Annual W.*(Private/Total Mileage):</label>
        <input type="number" id="driver" name="driver" class="form-control" value="<?TPLVAR_DRIVER?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(i) Upkeep of Compound:</label>
        <input type="number" id="upkeep" name="upkeep" class="form-control" value="<?TPLVAR_UPKEEP?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>(j) Taxable value of utilities (2g+2h+2i):</label>
        <input type="number" id="totalTaxableUtilities" name="totalTaxableUtilities" class="form-control" value="<?TPLVAR_TOTAL_UTILITIES?>" placeholder="Enter amount" disabled="disabled" />
    </div>
</div>

<strong class="select2-results__group iras_group">3. Hotel Accommodation Provided</strong>

<div class="row">
    <div class="col-md-4">
        <label>(a) Actual cost of Hotel accommodation:</label>
        <input type="number" id="hotel" name="hotel" class="form-control" value="<?TPLVAR_HOTEL?>" placeholder="Enter amount" />
    </div>
    <div class="col-md-4">
        <label>(b) Amount paid by the employee:</label>
        <input type="number" id="hotelPaidEmployee" name="hotelPaidEmployee" class="form-control" value="<?TPLVAR_HOTEL_PAID_EMPLOYEE?>" placeholder="Enter amount" />
    </div>
    <div class="col-md-4">
        <label>(c) Taxable Value of Hotel (3a-3b):</label>
        <input type="number" id="hotelTotal" name="hotelTotal" class="form-control" value="<?TPLVAR_HOTEL_TOTAL?>" placeholder="Enter amount" disabled="disabled" />
    </div>
</div>

<strong class="select2-results__group iras_group">4. Others</strong>

<div class="row">
    <div class="col-md-4">
        <label>(a) Home leave passages and benefits:</label>
        <input type="number" id="incidentalBenefits" name="incidentalBenefits" class="form-control" value="<?TPLVAR_INCIDENTAL_BENEFITS?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(b) Interest payment made by the employer:</label>
        <input type="number" id="interestPayment" name="interestPayment" class="form-control" value="<?TPLVAR_INTEREST_PAYMENT?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(c) Insurance premiums paid by the employer:</label>
        <input type="number" id="insurance" name="insurance" class="form-control" value="<?TPLVAR_INSURANCE?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>(d) Free or subsidised holidays including air passage, etc.:</label>
        <input type="number" id="holidays" name="holidays" class="form-control" value="<?TPLVAR_HOLIDAYS?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(e) Educational expenses including tutor provided:</label>
        <input type="number" id="education" name="education" class="form-control" value="<?TPLVAR_EDUCATION?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(f) Entrance/transfer fees and annual subscription to social or recreational clubs:</label>
            <input type="number" id="recreation" name="recreation" class="form-control" value="<?TPLVAR_RECREATION?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>(g) Gains from assets, e.g. vehicles, property, etc. sold to employees:</label>
        <input type="number" id="assetGain" name="assetGain" class="form-control" value="<?TPLVAR_ASSET_GAIN?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(h) Full cost of motor vehicles given to employee:</label>
        <input type="number" id="vehicleGain" name="vehicleGain" class="form-control" value="<?TPLVAR_VEHICLE_GAIN?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>(i) Full cost of motor vehicles given to employee:</label>
        <input type="number" id="carBenefits" name="carBenefits" class="form-control" value="<?TPLVAR_CAR_BENEFITS?>" placeholder="Enter amount" />
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>(j) Other non-monetary awards/benefits:</label>
        <input type="number" id="otherBenefits" name="otherBenefits" class="form-control" value="<?TPLVAR_OTHER_BENEFITS?>" placeholder="Enter amount" />
    </div>

    <div class="col-md-4">
        <label>Total Value of Benefits-In-Kind (Items 2-4):</label>
        <input type="number" id="totalBenefits" name="totalBenefits" class="form-control" value="<?TPLVAR_TOTAL_BENEFITS?>" placeholder="Enter amount" disabled="disabled" />
    </div>
</div>