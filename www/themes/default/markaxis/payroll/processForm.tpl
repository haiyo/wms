<form id="processForm" name="processForm" method="post" action="">
    <input type="hidden" id="userID" name="userID" value="<?TPLVAR_USERID?>" />
    <div class="row" style="border-bottom:1px solid #ccc;margin-top:0;padding-bottom:11px;">
        <div class="col-md-1" style="width: 10%;"><img width="95" src="<?TPLVAR_IMAGE?>"></div>
        <div class="col-md-4" style="width:29%;border-right: 1px solid #ccc;">
            <?TPL_COL_1?>
        </div>
        <div class="col-md-4" style="width:37%;padding-left:24px;border-right: 1px solid #ccc;">
            <?TPL_COL_2?>
        </div>
        <div class="col-md-3" style="width:22%;padding-left:24px;">
            <?TPL_COL_3?>
        </div>
    </div>

    <div class="row font-weight-semibold" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;margin-bottom:0;">
        <div class="col-md-4">Item Type:</div>
        <div class="col-md-3 amount">Amount:</div>
        <div class="col-md-4 remark">Remark</div>
        <div class="col-lg-1 sm-addrm text-right">&nbsp;</div>
    </div>

    <div id="itemWrapper" style="min-height:270px;max-height:166px;margin-bottom: 11px;border-bottom: 1px solid #ccc;overflow-y:auto;">
        <!-- BEGIN DYNAMIC BLOCK: item -->
        <div id="itemRowWrapper_<?TPLVAR_ID?>" class="row itemRow" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
            <div class="col-md-4">
                <?TPL_PAYROLL_ITEM_LIST?>
            </div>

            <div class="col-md-3 amount">
                <input type="text" name="amount_<?TPLVAR_ID?>" id="amount_<?TPLVAR_ID?>" class="form-control amountInput" value="<?TPLVAR_AMOUNT?>" placeholder="" />
            </div>

            <div class="col-md-4 remark">
                <input type="text" name="remark_<?TPLVAR_ID?>" class="form-control remark" value="<?TPLVAR_REMARK?>" placeholder="" autocomplete="off" data-fouc />
            </div>

            <div class="col-lg-1 sm-addrm text-center">
                <div class="mt-5 iconWrapper">
                    <a href="#" class="removeItem"><i id="plus_<?TPLVAR_ID?>" class="icon icon-minus-circle2"></i></a>
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

        <div class="col-md-4 text-light" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Employer CPF Contribution:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                -SGD$1,360
            </div>
        </div>

        <div class="col-md-4" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Gross Salary:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_GROSS_AMOUNT?>
            </div>
        </div>

    </div>

    <div class="row payrollProcessSummary">
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4 text-light" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Foreign Worker Levy (FWL):</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                -SGD$450
            </div>
        </div>

        <div class="col-md-4" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Claim:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_CLAIM_AMOUNT?>
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

        <div class="col-md-4 text-light" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Skill Development Levy (SDL):</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                -SGD$11.25
            </div>
        </div>

        <div class="col-md-4" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Tax / Deduction:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                -<?TPLVAR_CURRENCY?><?TPLVAR_DEDUCTION_AMOUNT?>
            </div>
        </div>
    </div>

    <div class="row payrollProcessSummary">
        <div class="col-md-4">&nbsp;</div>

        <div class="col-md-4 text-light" style="">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Employer Contribution:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                -SGD$1,371.25
            </div>
        </div>

        <div class="col-md-4" style="">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Net Payable:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_NET_AMOUNT?>
            </div>
        </div>
    </div>
</form>
<div id="itemTemplate" class="hide">
    <div id="itemRowWrapper_{id}" class="row itemRow" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-4">
            <?TPL_PAYROLL_ITEM_LIST?>
        </div>

        <div class="col-md-3 amount">
            <input type="text" name="amount_{id}" id="amount_{id}" class="form-control amountInput" value="" placeholder="" />
        </div>

        <div class="col-md-4 remark">
            <input type="text" name="remark_{id}" class="form-control remark" value="" placeholder="" autocomplete="off" data-fouc />
        </div>

        <div class="col-lg-1 sm-addrm text-center">
            <div class="mt-5 iconWrapper">
                <a href="#" class="addItem"><i id="plus_{id}" class="icon icon-plus-circle2"></i></a>
            </div>
        </div>
    </div>
</div>