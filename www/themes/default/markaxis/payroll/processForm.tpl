<form id="processForm" name="createTeamForm" method="post" action="">

    <div class="row" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-1" style="width: 10%;"><img width="95" src="<?TPLVAR_IMAGE?>"></div>
        <div class="col-md-3" style="width:29%;border-right: 1px solid #ccc;">
            <h5><strong>Employee:</strong> <?TPLVAR_FNAME?> <?TPLVAR_LNAME?></h5>
            <div class="text-light"><strong>Designation:</strong> <?TPLVAR_DESIGNATION?></div>
            <div class="text-light"><strong>Department:</strong> <?TPLVAR_DEPARTMENT?></div>
            <div class="text-light"><strong>Contract Type:</strong> <?TPLVAR_CONTRACT_TYPE?></div>
            <div class="text-light"><strong>Work Pass:</strong> <?TPLVAR_WORK_PASS?></div>
        </div>
        <!--
        ALTER TABLE `employee` CHANGE `oID` `officeID` INT(10) UNSIGNED NULL DEFAULT NULL;
    ALTER TABLE `employee` CHANGE `dID` `designationID` INT(10) UNSIGNED NULL DEFAULT NULL;
    ALTER TABLE `employee` CHANGE `cID` `contractID` INT(10) UNSIGNED NULL DEFAULT NULL;
    ALTER TABLE `employee` CHANGE `stID` `salaryTypeID` INT(10) UNSIGNED NULL DEFAULT NULL;
    ALTER TABLE `employee` CHANGE `pmID` `paymentMethodID` INT(10) UNSIGNED NULL DEFAULT NULL;
    ALTER TABLE `employee` CHANGE `bkID` `bankID` INT(10) UNSIGNED NULL DEFAULT NULL;
    ALTER TABLE `employee` CHANGE `ptID` `passTypeID` INT(10) UNSIGNED NULL DEFAULT NULL;

    ALTER TABLE `employee_bank` CHANGE `branchCode` `bankBranchCode` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
    ALTER TABLE `employee_bank` DROP `branchName`
    ALTER TABLE `employee_bank` DROP `pmID`

    ALTER TABLE `employee` ADD `departmentID` INT(10) UNSIGNED NOT NULL AFTER `officeID`;

    ALTER TABLE `employee`
      DROP `bankCode`,
      DROP `branchCode`,
      DROP `bankHolderName`,
      DROP `swiftCode`,
      DROP `branchName`;

    UPDATE employee SET departmentID = 1;

    DROP TABLE employee_department;
        -->
        <div class="col-md-3" style="width:33%;padding-left:24px;border-right: 1px solid #ccc;">
            <h5><strong>Employee ID:</strong> <?TPLVAR_IDNUMBER?></h5>
            <div class="text-light"><strong>Employment Start Date:</strong> <?TPLVAR_START_DATE?> (12yr 1 mth)</div>
            <div class="text-light"><strong>Employment End Date:</strong> <?TPLVAR_END_DATE?></div>
            <div class="text-light" style="overflow: hidden; text-overflow: ellipsis;"><strong>Total Working Days For This Month:</strong> 21 days</div>
        </div>
        <div class="col-md-4" style="width:28%;padding-left:24px;">
            <h5><strong>Payment Method:</strong> <?TPLVAR_PAYMENT_METHOD?></h5>
            <!-- BEGIN DYNAMIC BLOCK: bankInfo -->
            <div class="text-light"><strong>Bank:</strong> <?TPLVAR_BANK?></div>
            <div class="text-light"><strong>Bank No.:</strong> <?TPLVAR_BANK_NUMBER?></div>
            <div class="text-light"><strong>Bank / Branch Code:</strong> <?TPLVAR_BANK_CODE?> / <?TPLVAR_BRANCH_CODE?></div>
            <div class="text-light"><strong>Bank Swift Code:</strong> <?TPLVAR_BANK_SWIFT_CODE?></div>
            <!-- END DYNAMIC BLOCK: bankInfo -->
        </div>
    </div>

    <div class="row font-weight-semibold" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-4">Item Type:</div>
        <div class="col-md-2 amount">Amount:</div>
        <div class="col-md-4 remark">Remark</div>
        <div class="col-lg-1 sm-check text-center">Taxable</div>
        <div class="col-lg-1 sm-addrm text-right">&nbsp;</div>
    </div>

    <div class="row" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-4">
            <select class="form-control itemType">
                <option>Advance Pay</option>
                <option>Allowance</option>
                <option>Basic Pay</option>
                <option>Commission</option>
                <option>Deduction</option>
                <option>Director fees</option>
                <option>Extra Duty Allowance</option>
                <option>Housing / Rental Allowance</option>
                <option>Incentive Allowance</option>
                <option>Meal Allowance</option>
                <option>Per Diem Allowance</option>
                <option>Tips</option>
                <option>Transport Allowance</option>
            </select>
        </div>

        <div class="col-md-2 amount">
            <input type="text" name="teamName" id="teamName" class="form-control" value="SGD$3,000"
                   placeholder="" />
        </div>

        <div class="col-md-4 remark">
            <input type="text" name="teamMembers" class="form-control tokenfield-typeahead teamMemberList"
                   placeholder="" autocomplete="off" data-fouc />
        </div>

        <div class="col-lg-1 sm-check text-center">
            <div class="mt-5"><input type="checkbox" class="check-input" checked data-fouc></div>
        </div>

        <div class="col-lg-1 sm-addrm text-center">
            <div class="mt-5">
                <a href="0" class="addChildren"><i id="plus_0" class="icon-plus-circle2"></i></a>
            </div>
        </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-4">
            <select class="form-control itemType">
                <option>Advance Pay</option>
                <option>Allowance</option>
                <option>Basic Pay</option>
                <option>Commission</option>
                <option>Deduction</option>
                <option>Director fees</option>
                <option>Extra Duty Allowance</option>
                <option>Housing / Rental Allowance</option>
                <option>Incentive Allowance</option>
                <option>Meal Allowance</option>
                <option>Per Diem Allowance</option>
                <option>Tips</option>
                <option>Transport Allowance</option>
            </select>
        </div>

        <div class="col-md-2 amount">
            <input type="text" name="teamName" id="teamName" class="form-control" value="SGD$30"
                   placeholder="" />
        </div>

        <div class="col-md-4 remark">
            <input type="text" name="teamMembers" class="form-control tokenfield-typeahead teamMemberList"
                   placeholder="" autocomplete="off" data-fouc />
        </div>

        <div class="col-lg-1 sm-check text-center">
            <div class="mt-5"><input type="checkbox" class="check-input" checked data-fouc></div>
        </div>

        <div class="col-lg-1 sm-addrm text-center">
            <div class="mt-5">
                <a href="0" class="addChildren"><i id="plus_0" class="icon-plus-circle2"></i></a>
            </div>
        </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-4">
            <select class="form-control itemType">
                <option>Advance Pay</option>
                <option>Allowance</option>
                <option>Basic Pay</option>
                <option>Commission</option>
                <option>Deduction</option>
                <option>Director fees</option>
                <option>Extra Duty Allowance</option>
                <option>Housing / Rental Allowance</option>
                <option>Incentive Allowance</option>
                <option>Meal Allowance</option>
                <option>Per Diem Allowance</option>
                <option>Tips</option>
                <option>Transport Allowance</option>
            </select>
        </div>

        <div class="col-md-2 amount">
            <input type="text" name="teamName" id="teamName" class="form-control" value="SGD$30"
                   placeholder="" />
        </div>

        <div class="col-md-4 remark">
            <input type="text" name="teamMembers" class="form-control tokenfield-typeahead teamMemberList"
                   placeholder="" autocomplete="off" data-fouc />
        </div>

        <div class="col-lg-1 sm-check text-center">
            <div class="mt-5"><input type="checkbox" class="check-input" checked data-fouc></div>
        </div>

        <div class="col-lg-1 sm-addrm text-center">
            <div class="mt-5">
                <a href="0" class="addChildren"><i id="plus_0" class="icon-plus-circle2"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4 text-light">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Foreign Worker Levy (FWL):</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$450
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Total Gross Salary:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                SGD$8,000
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4 text-light">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Skill Development Levy (SDL):</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$11.25
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>SHG Donation (CDAC):</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$2.00
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4 text-light">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Employer CPF Contribution:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$1,360
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Employee CPF:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$2,200
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="prePopulateTxt">
                <div class="row">
                    <div class="tipsIco"><strong><i class="mi-lightbulb-outline"></i></strong></div>
                    <div class="tipsTxt">
                        <strong>Tips:</strong>
                        You can pre-populate employee's payroll using previous month
                        template. This saves you time to re-enter the same set of data every month.
                    </div>
                </div>
                <button id="useTemplate" type="submit" class="btn btn-primary useTemplate">Use Previous Month Template</button>
            </div>
        </div>

        <div class="col-md-4 text-light">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Total Employer Contribution:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$1,371.25
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Total Deduction:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$2,202
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Total Net Payable:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                SGD$5,798
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
        <button id="createTeam" type="submit" class="btn btn-primary">Save Payroll</button>
    </div>
</form>