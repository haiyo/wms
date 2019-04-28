<form id="processForm" name="createTeamForm" method="post" action="">

    <div class="row" style="border-bottom:1px solid #ccc;margin-top:0;padding-bottom:11px;">
        <div class="col-md-1" style="width: 10%;"><img width="95" src="<?TPLVAR_IMAGE?>"></div>
        <div class="col-md-3" style="width:29%;border-right: 1px solid #ccc;">
            <h5><strong>Employee:</strong> <?TPLVAR_FNAME?> <?TPLVAR_LNAME?> (Age: <?TPLVAR_AGE?>)</h5>
            <div class="text-light"><strong>Designation:</strong> <?TPLVAR_DESIGNATION?></div>
            <div class="text-light"><strong>Department:</strong> <?TPLVAR_DEPARTMENT?></div>
            <div class="text-light"><strong>Contract Type:</strong> <?TPLVAR_CONTRACT_TYPE?></div>
            <div class="text-light"><strong>Work Pass:</strong> <?TPLVAR_WORK_PASS?></div>
        </div>
        <div class="col-md-3" style="width:33%;padding-left:24px;border-right: 1px solid #ccc;">
            <h5><strong>Employee ID:</strong> <?TPLVAR_IDNUMBER?></h5>
            <div class="text-light"><strong>Employment Start Date:</strong> <?TPLVAR_START_DATE?> (<?TPLVAR_DURATION_YEAR?>yr <?TPLVAR_DURATION_MONTH?>mth)</div>
            <div class="text-light"><strong>Employment End Date:</strong> <?TPLVAR_END_DATE?></div>
            <div class="text-light"><strong>Employment Confirm Date:</strong> <?TPLVAR_CONFIRM_DATE?></div>
            <div class="text-light" style="overflow: hidden; text-overflow: ellipsis;"><strong>Total Work Days For This Month:</strong> 21 days</div>
        </div>
        <div class="col-md-4" style="width:28%;padding-left:24px;">
            <h5><strong>Payment Method:</strong> <?TPLVAR_PAYMENT_METHOD?></h5>
            <div class="text-light"><strong>Bank:</strong> <?TPLVAR_BANK_NAME?></div>
            <div class="text-light"><strong>Bank No.:</strong> <?TPLVAR_BANK_NUMBER?></div>
            <div class="text-light"><strong>Bank / Branch Code:</strong> <?TPLVAR_BANK_CODE?> / <?TPLVAR_BRANCH_CODE?></div>
            <div class="text-light"><strong>Bank Swift Code:</strong> <?TPLVAR_BANK_SWIFT_CODE?></div>
        </div>
    </div>

    <div class="row font-weight-semibold" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;margin-bottom:0;">
        <div class="col-md-4">Item Type:</div>
        <div class="col-md-3 amount">Amount:</div>
        <div class="col-md-4 remark">Remark</div>
        <div class="col-lg-1 sm-addrm text-right">&nbsp;</div>
    </div>

    <div id="itemWrapper" style="min-height:180px;max-height:166px;margin-bottom: 11px;border-bottom: 1px solid #ccc;overflow-y:auto;">
        <!-- BEGIN DYNAMIC BLOCK: item -->
        <div class="row" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
            <div class="col-md-4">
                <?TPL_PAYROLL_ITEM_LIST?>
            </div>

            <div class="col-md-3 amount">
                <input type="text" name="amount" id="amount" class="form-control" value="<?TPLVAR_AMOUNT?>" placeholder="" />
            </div>

            <div class="col-md-4 remark">
                <input type="text" name="remark" class="form-control" value="<?TPLVAR_REMARK?>" placeholder="" autocomplete="off" data-fouc />
            </div>

            <div class="col-lg-1 sm-addrm text-center">
                <div class="mt-5">
                    <a href="0" class="addChildren"><i id="plus_0" class="icon-plus-circle2"></i></a>
                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: item -->
    </div>

    <div class="row payrollProcessSummary">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4">
            &nbsp;
        </div>
    </div>

    <div class="row payrollProcessSummary">
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4 text-light">
            <div class="col-md-8 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                <strong>Employer CPF Contribution:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$1,360
            </div>
        </div>

        <div class="col-md-4">&nbsp;</div>

    </div>

    <div class="row payrollProcessSummary">
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
                <?TPLVAR_CURRENCY?><?TPLVAR_GROSS_AMOUNT?>
            </div>
        </div>
    </div>

    <div class="row payrollProcessSummary">
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
                <strong>Skill Development Levy (SDL):</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                -SGD$11.25
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

    <div class="row payrollProcessSummary">
        <div class="col-md-4">&nbsp;</div>

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
                <strong>Total Net Payable:</strong>
            </div>
            <div class="col-md-4 text-right" style="border-bottom:1px solid #ccc;padding:5px;">
                SGD$5,798
            </div>
        </div>
    </div>
</form>